<?php

namespace App\Utils;

use App\Models\Console;
use App\Models\ShopItem;
use App\Models\ShopOrder;

class ConsoleManager
{
    /**
     * From a shop order will create the consoles
     *
     * @param ShopOrder $shopOrder
     * @return array
     */
    public static function createConsolesFromOrder($shopOrder)
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
                $console->save();
                $consolesId['consoles_ids'][] = $console['id'];
            }
        }
        return $result;
    }
}