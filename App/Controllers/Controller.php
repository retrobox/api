<?php
namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Router;

class Controller{
	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @var Container
	 */
	protected $container;

	public function __construct(Router $router, Container $container)
	{
		$this->router = $router;
		$this->container = $container;
	}

	public function redirect(ResponseInterface $response, $location){
		return $response->withStatus(302)->withHeader('Location', $location);
	}

	/**
	 * Helper for render function
	 * Please give file name without extension
	 *
	 * @param ResponseInterface $response
	 * @param $file
	 * @param array $params
	 */
	public function render(ResponseInterface $response, $file, $params = []){
		//require file without .twig extension
		$file = str_replace('.', '/', $file) . '.twig';
		$this->view->render($response, $file, $params);
	}

	public function pathFor($name, $params = []){
		return $this->router->pathFor($name, $params);
	}
}