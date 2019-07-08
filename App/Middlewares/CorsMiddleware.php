<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class CorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, Response $response, $next)
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
