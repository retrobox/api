<?php

namespace App\Utils;

use App\Models\Console;
use App\Models\ShopItem;
use App\Models\ShopOrder;
use Psr\Container\ContainerInterface;

class ConsoleManager
{
    /**
     * From a shop order will create the consoles
     *
     * @param ContainerInterface $container
     * @param ShopOrder $shopOrder
     * @return array
     */
    public static function createConsolesFromOrder(ContainerInterface $container, $shopOrder)
    {
        $result = ['consoles_ids' => [], 'items' => []];
        foreach ($shopOrder['items'] as $item) {
            /**
             * @var $item ShopItem
             */
            $result['items'][] = $item->toArray();
            $category = $item->category()->first()->toArray();
            if ($category['is_customizable']) {
                // at this point we consider this shop item as a console
                $console = new Console();
                $console['id'] = \App\GraphQL\Query\Console::generateRandom(5);
                $console['user_id'] = $shopOrder->user()->first()->toArray()['id'];
                $console['order_id'] = $shopOrder['id'];
                $console['storage'] = $item['pivot']['shop_item_custom_option_storage'];
                $console['color'] = $item['pivot']['shop_item_custom_option_color'];
                $console['token'] = \App\GraphQL\Query\Console::generateRandom(32);
                $console['version'] = ConsoleManager::getLatestConsoleVersion($container)['id'];
                $console->save();
                $consolesId['consoles_ids'][] = $console['id'];
            }
        }
        return $result;
    }

    /**
     * Will return the last console version object from 'console-versions.php' container file
     *
     * @param ContainerInterface $container
     * @return array
     */
    public static function getLatestConsoleVersion(ContainerInterface $container): array
    {
        return array_values(array_filter(
            $container->get('console-versions'),
            fn($v) => isset($v['latest']) && $v['latest']
        ))[0];
    }
}