<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PagesController extends Controller
{
	public function getHome(ServerRequestInterface $request, ResponseInterface $response)
	{
		return $response->withJson([
			'This is the main page of the API!',
			'Welcome in your application!',
			'This api support REST and GraphQL'
		]);
	}
}