<?php /** @noinspection PhpDocMissingThrowsInspection */

namespace App\Utils;

use App\Models\ShopItem;
use App\Models\ShopOrder;
use App\Models\User;
use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use Psr\Container\ContainerInterface;

class PaymentManager
{
    /**
     * @var array
     */
    private array $items;

    /**
     * @var array
     */
    private array $pivotsAttributes;

    /**
     * @var float
     */
    private float $subTotalPrice = 0.00;

    /**
     * @var float
     */
    private float $totalShippingPrice = 0.00;

    /**
     * @var float
     */
    private float $totalPrice = 0.00;

    /**
     * Description displayed on paypal invoice
     *
     * @var string
     */
    private string $paypalDescription = "retrobox.tech";

//    /**
//     * The shipping prices range
//     *
//     * @var array
//     */
//    private array $shippingPrices = [];

    /**
     * The storage prices range
     *
     * @var array
     */
    private array $storagePrices;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var array
     */
    private array $shippingAddress;

    /**
     * @var string
     */
    private string $shippingMethod;

    /**
     * The total weight of the order in S.I grams
     *
     * @var int
     */
    private int $totalWeight = 0;

    /**
     * @var bool
     */
    private bool $isValid = true;

    /**
     * PaymentManager constructor.
     *
     * @param array $items
     * @param array $shippingAddress The user address object
     * @param string $shippingMethod
     * @param ContainerInterface $container
     */
    public function __construct(
        array $items,
        array $shippingAddress,
        string $shippingMethod,
        ContainerInterface $container
    )
    {
        $this->container = $container;
        $this->storagePrices = $container->get('shop')['storage_prices'];
        $this->items = $items;
        $this->shippingAddress = $shippingAddress;
        $this->shippingMethod = $shippingMethod;
        $this->items = $this->fetchItems();
    }

    /**
     * Return fetched items
     *
     * @return array
     * @throws Exception
     */
    private function fetchItems(): array
    {
        $items = [];
        if (count($this->items) > 0) {
            foreach ($this->items as $item) {
                $pivotsAttributes = [
                    'shop_item_custom_option_storage' => NULL,
                    'shop_item_custom_option_color' => NULL
                ];
                if (!isset($item['id'])) {
                    throw new Exception('Invalid item', 400);
                }
                $toAddItem = ShopItem::query()->find($item['id']);
                if ($toAddItem == NULL) {
                    // the item is not found
                    $this->isValid = false;
                    return [];
                }
                $toAddItem = $toAddItem->toArray();

                //add option price
                if (isset($item['custom_options'])) {
                    $toAddItem['custom_options'] = $item['custom_options'];
                    if (isset($item['custom_options']['color'])) {
                        $pivotsAttributes['shop_item_custom_option_color'] = $item['custom_options']['color'];
                    }
                    if (isset($item['custom_options']['storage'])) {
                        $pivotsAttributes['shop_item_custom_option_storage'] = $item['custom_options']['storage'];
                    }
                }
                //or using the database
                if (isset($item['pivot']) && $item['pivot']['shop_item_custom_option_storage'] != NULL) {
                    $toAddItem['custom_options']['storage'] = $item['pivot']['shop_item_custom_option_storage'];
                }

                $toAddItem['sub_total_price'] = $toAddItem['price']
                    + $this->getOptionPrice($toAddItem);
                $this->subTotalPrice += $toAddItem['sub_total_price'];
                $this->totalWeight += $toAddItem['weight'];

                $this->pivotsAttributes[] = $pivotsAttributes;
                $items[] = $toAddItem;
            }
        }

        $this->totalShippingPrice = $this->getShippingPrice($this->totalWeight);
        $this->totalPrice += $this->subTotalPrice + $this->totalShippingPrice;
        return $items;
    }

    private function getOptionPrice(array $item): float
    {
        if (isset($item['custom_options']['storage'])) {
            if (isset($this->storagePrices[$item['custom_options']['storage']])) {
                return $this->storagePrices[$item['custom_options']['storage']];
            }
        }
        return 0.00;
    }

    /**
     * Return the shipping price for this order NOT IN CENTS
     *
     * @param float $weight
     * @return float NOT IN CENTS
     */
    private function getShippingPrice(float $weight): float
    {
        $colissimo = $this->container->get(Colissimo::class);
        $chronopost = $this->container->get(Chronopost::class);
        $countriesHelper = $this->container->get(Countries::class);
        if (!$countriesHelper->isCountryCodeValid($this->shippingAddress['country'])) {
            // invalid shipping country
            $this->isValid = false;
            return 0;
        }
        switch ($this->shippingMethod) {
            case 'colissimo':
                $price = $colissimo->getPrice($this->shippingAddress['country'], $weight);
                break;
            case 'chronopost':
                $price = $chronopost->getPrice(
                    $this->shippingAddress['country'],
                    $this->shippingAddress['postal_code'],
                    $weight
                );
                break;
            default:
                // invalid shipping method
                $this->isValid = false;
                return 0;
        }
        return round($price / 100, 2);
    }

    public function getTotalShippingPrice(): float
    {
        return $this->totalShippingPrice;
    }

    public function getSubTotalPrice(): float
    {
        return $this->subTotalPrice;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getParsedItems(): array
    {
        return $this->items;
    }

    public function getPivotsAttributes(): array
    {
        return $this->pivotsAttributes;
    }

    public function toPaypalTransaction(?string $custom = null): Transaction
    {
        $list = new ItemList();
        foreach ($this->getParsedItems() as $item) {
            $list->addItem(
                (new Item())
                    ->setName($item['title'])
                    ->setPrice($item['sub_total_price'])
                    ->setCurrency('EUR')
                    ->setQuantity(1)
            );
        }
        $details = (new Details())
            ->setShipping($this->getTotalShippingPrice())
            ->setSubtotal($this->getSubTotalPrice());

        $amount = (new Amount())
            ->setTotal($this->getTotalPrice())
            ->setCurrency("EUR")
            ->setDetails($details);

        return (new Transaction())
            ->setItemList($list)
            ->setDescription($this->paypalDescription)
            ->setAmount($amount)
            ->setCustom($custom);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getModels(): array
    {
        $models = [];
        foreach ($this->fetchItems() as $item) {
            $models[] = ShopItem::query()->where('id', '=', $item['id'])->first();
        }
        return $models;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function toStripeSession(): array
    {
        $items = [];
        foreach ($this->getParsedItems() as $item) {
            $items[] = [
                'name' => $item['title'],
                'description' => $item['description_short'],
                'images' => [$item['image']],
                'amount' => $item['sub_total_price'] * 100,
                'currency' => 'eur',
                'quantity' => 1
            ];
        }
        $items[] = [
            'name' => 'Shipping',
            'description' => ucfirst($this->shippingMethod) . ' ' . $this->shippingAddress['country'],
            'images' => ['https://static.retrobox.tech/img/shipping/' . $this->shippingMethod . '.png'],
            'amount' => $this->getTotalShippingPrice() * 100,
            'currency' => 'eur',
            'quantity' => 1
        ];
        return [
            'line_items' => $items
        ];
    }

    /**
     * Will remove all non payed orders entries of an given user
     *
     * @param User $user
     */
    public static function destroyNotPayedOrder(User $user): void
    {
        $notPayedOrders = $user->shopOrders()
            ->where('status', '=', 'not-payed')
            ->get();
        ShopOrder::destroy(array_map(fn($order) => $order['id'], $notPayedOrders->toArray()));
    }

    /**
     * Will return a ShopOrder entry based of the PaymentManager data
     *
     * @return ShopOrder
     * @throws Exception
     */
    public function toShopOrder(): ShopOrder
    {
        $order = new ShopOrder();
        $order['id'] = uniqid();
        $order['total_price'] = $this->getTotalPrice();
        $order['sub_total_price'] = $this->getSubTotalPrice();
        $order['total_shipping_price'] = $this->getTotalShippingPrice();
        $order['status'] = 'not-payed';
        $order->items()->saveMany($this->getModels(), $this->getPivotsAttributes());

        return $order;
    }
}
