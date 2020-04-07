<?php

namespace App\Utils;

use App\Models\ShopCategory;
use App\Models\ShopItem;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Container\ContainerInterface;

class CacheManager {

    /**
     * Will generate (clear then recreate) the shop item cache
     *
     * @param ContainerInterface $container
     * @param string $locale The locale of the cache version
     * @param string $slug THe slug of the item
     * @return array The generated cache array data
     */
    public static function generateShopItem(ContainerInterface $container, string $locale, string $slug): array
    {
        $item = ShopItem::with('categoryWithItems', 'images')
            ->where('slug', '=', $slug)
            ->where('locale', '=', $locale)
            ->first();
        if ($item == NULL) {
            return [];
        }
        $render = $item->toArray();
        $render['category'] = $render['category_with_items'];
        unset($render['category_with_items']);
        $key = 'shop_item_' . $locale . '_' . $slug;
        $container->get(LocalStorage::class)
            ->remove($key)
            ->set($key, $render)
            ->save();
        return $render;
    }

    /**
     * Will generate (clear then recreate) the shop categories cache
     *
     * @param ContainerInterface $container
     * @param string $locale The locale of the cache version
     * @return array The generated cache array data
     */
    public static function generateShopCategories(ContainerInterface $container, string $locale): array
    {
        $categories = ShopCategory::with('items')
            ->where('locale', '=', $locale)
            ->orderBy('order', 'asc')
            ->get()
            ->toArray();
        $key = 'shop_categories_' . $locale;
        $container->get(LocalStorage::class)
            ->remove($key)
            ->set($key, $categories)
            ->save();
        return $categories;
    }
}