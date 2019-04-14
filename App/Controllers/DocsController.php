<?php

namespace App\Controllers;

use Slim\Http\Response;

class DocsController extends Controller
{
    public function getPage($locale, $slug, Response $response)
    {
        $docEndpoint = $this->container->get('services')['docs_endpoint'];
        $config = json_decode(file_get_contents($docEndpoint . '/config.json'), true);
        $localeConfig = array_filter($config['locales'], function ($item) use ($locale){
            return $item['slug'] === $locale;
        })[0];
        if ($slug === 'home' || $slug === 'undefined') {
            $title = $localeConfig['home']['name'];
            $slugToGet = $localeConfig['home']['slug'];
            $nextItem = $localeConfig['tree'][0];
            $previousItem = NULL;
            $indexOf = NULL;
        } else {
            $pageConfig = array_filter($localeConfig['tree'], function ($item) use ($slug) {
               return $item['slug'] === $slug;
            });
            $pageConfig = array_values($pageConfig)[0];
            $title = $pageConfig['name'];
            $slugToGet = $slug;
            $indexOf = array_search($pageConfig, $localeConfig['tree']);
            $nextItem = isset($localeConfig['tree'][$indexOf+1]) ? $localeConfig['tree'][$indexOf+1] : NULL;
            $previousItem = isset($localeConfig['tree'][$indexOf-1]) ? $localeConfig['tree'][$indexOf-1] : NULL;
            if ($indexOf == 0) {
                $previousItem = $localeConfig['home'];
            }
        }
        $pageContent = file_get_contents($docEndpoint . '/content/' . $locale . '/' . $slugToGet . '.md');
        return $response->withJson([
            'success' => true,
            'data' => [
                'title' => $title,
                'tree' => $localeConfig['tree'],
                'content' => $pageContent,
                'next' => $nextItem,
                'previous' => $previousItem,
                'locale' => $locale,
                'locale_name' => $localeConfig['name'],
                'slug' => $slug,
                'index_of' => $indexOf
            ]
        ]);
    }
}
