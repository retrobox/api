<?php

namespace App\Utils;

use App\Colissimo\Client;
use App\Models\ShopItem;
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
    private $items;

    /**
     * @var array
     */
    private $pivotsAttributes;

    /**
     * @var float
     */
    private $subTotalPrice = 0.00;

    /**
     * @var float
     */
    private $totalShippingPrice = 0.00;

    /**
     * @var float
     */
    private $totalPrice = 0.00;

    /**
     * Description displayed on paypal invoice
     *
     * @var string
     */
    private $paypalDescription = "retrobox.tech";

    /**
     * The shipping prices range
     *
     * @var array
     */
    private $shippingPrices = [];

    /**
     * The storage prices range
     *
     * @var array
     */
    private $storagePrices = [];

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var string
     */
    private $shippingCountry;
    /**
     * @var string
     */
    private $shippingMethod;
    /**
     * @var float
     */
    private $totalWeight;

    /**
     * @var bool
     */
    private $isValid = true;

    public function __construct(array $items, string $shippingCountry, string $shippingMethod, ContainerInterface $container)
    {
        $this->container = $container;
        $this->storagePrices = $container->get('shop')['storage_prices'];
        $this->items = $items;
        $this->shippingCountry = $shippingCountry;
        $this->shippingMethod = $shippingMethod;
        $this->items = $this->fetchItems();
    }

    /**
     * Return fetched items
     *
     * @return array
     * @throws \Exception
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
                    throw new \Exception('Invalid item', 400);
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
                $this->totalWeight += (float)$toAddItem['weight'];

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

    private function getShippingPrice(float $weight): float
    {
        $client = $this->container->get(Client::class);
        $countriesHelper = $this->container->get(Countries::class);
        if (!$countriesHelper->isCountryCodeValid($this->shippingCountry)) {
            // invalid shipping country
            $this->isValid = false;
            return 0;
        }
        switch ($this->shippingMethod) {
            case 'colissimo':
                return $client->getPrice('fr', $this->shippingCountry, $weight);
                break;
            case 'chronopost':
                return 0;
                break;
            default:
                // invalid shipping method
                $this->isValid = false;
                return 0;
                break;
        }
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

    public function toPaypalTransaction($custom = NULL): Transaction
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

}
