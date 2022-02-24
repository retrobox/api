<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, Authorization');

        if ($request->getMethod() == "OPTIONS") {
            return $response->withJson(true);
        }

        return $response;
    }
}
