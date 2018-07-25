<?php

namespace App\Controllers;

use App\Models\ShopCategory;
use App\Models\ShopItem;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShopController extends Controller
{
    public function getCategories($locale, ServerRequestInterface $request, ResponseInterface $response, Manager $manager)
    {
        if (array_search($locale, $this->container->get('locales')) !== false){
            $categories = ShopCategory::with('items')->where('locale', '=', $locale)->get();
            return $response->withJson([
                'success' => true,
                'data' => [
                    'categories' => $categories->toArray()
                ]
            ]);
        }else{
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown locale slug'
                ]
            ])->withStatus(404);
        }
    }

    public function getItem($locale, $slug, ServerRequestInterface $request, ResponseInterface $response, Manager $manager)
    {
        $item = ShopItem::with('categoryWithItems', 'images')
            ->where('slug', '=', $slug)
            ->where('locale', '=', $locale)
            ->first();
        if ($item == NULL){
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown shop item'
                ]
            ])->withStatus(404);
        }else{
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
}