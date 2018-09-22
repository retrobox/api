<?php

namespace App\Controllers;

use App\Models\ShopCategory;
use App\Models\ShopItem;
use Illuminate\Database\Capsule\Manager;
use Slim\Http\Response;

class ShopController extends Controller
{
    public function getCategories($locale, Response $response)
    {
        $this->container->get(Manager::class);
        if (array_search($locale, $this->container->get('locales')) !== false) {
            $categories = ShopCategory::with('items')
                ->where('locale', '=', $locale)
                ->orderBy('order', 'asc')
                ->get();
            return $response->withJson([
                'success' => true,
                'data' => [
                    'categories' => $categories->toArray()
                ]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown locale slug'
                ]
            ])->withStatus(404);
        }
    }

    public function getItem($locale, $slug, Response $response)
    {
        $this->container->get(Manager::class);
        $item = ShopItem::with('categoryWithItems', 'images')
            ->where('slug', '=', $slug)
            ->where('locale', '=', $locale)
            ->first();
        if ($item == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown shop item'
                ]
            ])->withStatus(404);
        } else {
            $render = $item->toArray();
            $render['category'] = $render['category_with_items'];
            unset($render['category_with_items']);
            return $response->withJson([
                'success' => true,
                'data' => [
                    'item' => $render
                ]
            ]);
        }
    }

    public function getPrices(Response $response)
    {
        return $response->withJson([
            'success' => true,
            'data' => [
                'shipping_prices' => $this->container->get('shop')['shipping_prices'],
                'storage_prices' => $this->container->get('shop')['storage_prices']
            ]
        ]);
    }
}