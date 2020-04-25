<?php

namespace App\Utils;

use Psr\Http\Message\ServerRequestInterface;

class AcceptLanguage {
    public static function getLanguageFromRequest(ServerRequestInterface $request): string
    {
        $rawLocale = $request->getHeader('Accept-Language')[0];
        return self::getLanguageFromHeader($rawLocale);
    }

    public static function getLanguageFromHeader(string $rawLocale): string
    {
        if (strlen($rawLocale) == 1) {
            return false;
        } else if (strlen($rawLocale) == 2){
            preg_match_all('/[a-zA-Z]{2}/m', $rawLocale, $matches, PREG_SET_ORDER, 0);
            return isset($matches[0][0]) ? $matches[0][0] : false;
        } else if (strlen($rawLocale) >= 4 && strlen($rawLocale) <= 5 && strpos($rawLocale, '-') !== false){
            $matches = explode('-', $rawLocale);
            return isset($matches[0]) ? $matches[0] : false;
        } else {
            if (strpos($rawLocale, ',') === false) {
                return false;
            }
            $locale = explode(',', $rawLocale);
            if (!isset($locale[0])) {
                return false;
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
