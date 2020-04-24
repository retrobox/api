<?php

namespace App\Controllers;

use App\App;
use GraphQL\GraphQL;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class GraphQlController extends Controller
{
	public function newRequest(ServerRequestInterface $request, Response $response)
	{
	    $this->container->get(Manager::class);
		$schema = require App::getBasePath() . '/App/GraphQL/schema.php';
		$input = $request->getParsedBody();
		if (!isset($input['query'])) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => "'query' field required on a GraphQL endpoint"]
                ]
            ], 400);
        }
		$query = $input['query'];
		$variableValues = isset($input['variables']) ? $input['variables'] : NULL;
        $result = GraphQL::executeQuery(
            $schema,
            $query,
            $this->container,
            NULL,
            $variableValues
        );

        if ($result->errors) {
            $code = 400;
            // catch others error than 400 (like 403)
            if ($result->errors[0]->getPrevious() != NULL
                && $result->errors[0]->getPrevious()->getCode() != 0
                && $result->errors[0]->getPrevious()->getCode() > 400
                && $result->errors[0]->getPrevious()->getCode() < 550){
                $code = $result->errors[0]->getPrevious()->getCode();
            }
            return $response->withJson([
                'success' => false,
                'errors' => $result->errors,
            ])->withStatus($code);
        } else {
            return $response->withJson([
                'success' => true,
                'data' => $result->data,
            ]);
        }
	}
}
