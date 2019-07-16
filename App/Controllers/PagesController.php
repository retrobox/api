<?php

namespace App\Controllers;

use App\Auth\Session;
use App\WebSocketServerClient;
use Slim\Http\Response;

class PagesController extends Controller
{
	public function getHome(Response $response)
	{
		return $response->withJson([
		    'success' => true,
            'data' => [
                'name' => $this->container->get('app_name'),
                'env' => $this->container->get('env_name')
            ]
		]);
	}

	public function getPing(Response $response)
    {
        return $response->withJson(['success' => true]);
    }

    public function getWebSocketConnexions(Response $response, Session $session) {
	    if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
	    return $response->withJson([
	        'success' => true,
            'data' => $this->container->get(WebSocketServerClient::class)->getConnexions()
        ]);
    }
}
