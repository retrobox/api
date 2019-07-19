<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;

class NotFoundHandler extends NotFound
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
	{
		parent::__invoke($request, $response);

		return $response->withJson([
			'success' => false,
			'errors' => [
				'Route not found'
			]
		])->withStatus(404);
	}
}
