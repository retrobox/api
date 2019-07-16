<?php

namespace App\Controllers;

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
}
