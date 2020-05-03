<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;

class NotAllowedHandler extends NotFound
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
	{
		parent::__invoke($request, $response);

        return $response->withJson([
            'success' => false,
            'errors' => [
                ['message' => 'Method not allowed']
            ]
        ], 405);
	}
}
