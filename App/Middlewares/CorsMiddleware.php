<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization');
        if ($request->getMethod() == "OPTIONS") {
            return $response->withJson(true);
        }
        return $next($request, $response);
    }
}
