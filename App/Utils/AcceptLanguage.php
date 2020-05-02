<?php

namespace App\Utils;

use Psr\Http\Message\ServerRequestInterface;

class AcceptLanguage {
    public static function getLanguageFromRequest(ServerRequestInterface $request): string
    {
        if (!$request->hasHeader('Accept-Language'))
            return '';
        $rawLocale = $request->getHeader('Accept-Language')[0];
        return self::getLanguageFromHeader($rawLocale);
    }

    public static function getLanguageFromHeader(string $rawLocale): string
    {
        if (strlen($rawLocale) == 1) {
            return '';
        } else if (strlen($rawLocale) == 2){
            preg_match_all('/[a-zA-Z]{2}/m', $rawLocale, $matches, PREG_SET_ORDER, 0);
            return isset($matches[0][0]) ? $matches[0][0] : '';
        } else if (strlen($rawLocale) >= 4 && strlen($rawLocale) <= 5 && strpos($rawLocale, '-') !== '') {
            $matches = explode('-', $rawLocale);
            return isset($matches[0]) ? $matches[0] : '';
        } else {
            if (strpos($rawLocale, ',') === '') {
                return '';
            }
            $locale = explode(',', $rawLocale);
            if (!isset($locale[0])) {
                return '';
            } else {
                preg_match_all('/;q=[0-9.]+/m', $locale[0], $matches, PREG_SET_ORDER, 0);
                if (isset($matches[0])) {
                    $locale = str_replace($matches[0], '', $locale[0]);
                } else {
                    $locale = $locale[0];
                }
                return self::getLanguageFromHeader($locale);
            }
        }
    }
}
