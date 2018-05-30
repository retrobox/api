<?php

namespace App;

use Slim\Handlers\NotFound;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

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