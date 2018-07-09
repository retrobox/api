<?php

namespace App\Controllers;

use DI\Container;
use GraphQL\GraphQL;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use GraphQL\Validator\DocumentValidator;

class GraphQlController extends Controller
{
	public function newRequest(ServerRequestInterface $request, ResponseInterface $response, Manager $manager, Container $container)
	{
		$schema = include "../App/GraphQL/schema.php";

		$input = $request->getParsedBody();
		$query = $input['query'];
		$variableValues = isset($input['variables']) ? $input['variables'] : NULL;

		try {
			$result = GraphQL::executeQuery(
				$schema,
				$query,
				[
					'manager' => $manager,
					'container' => $container
				],
				NULL,
				$variableValues
			);

			if ($result->errors) {
				return $response->withJson([
					'success' => false,
					'errors' => $result->errors,
				])->withStatus(400);
			} else {
				return $response->withJson([
					'success' => true,
					'data' => $result->data,
				]);
			}
		} catch (\Exception $e) {
			return $response->withJson([
				'success' => false,
				'error' => $e->getMessage()
			])->withStatus(400);
		}
	}
}