<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Router;

class Controller{
	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	public function __construct(Router $router, ContainerInterface $container)
	{
		$this->router = $router;
		$this->container = $container;
	}

    /**
     * @param ResponseInterface $response
     * @param $location
     * @return ResponseInterface
     */
    public function redirect(ResponseInterface $response, $location){
		return $response->withStatus(302)->withHeader('Location', $location);
	}

	public function pathFor($name, $params = []){
		return $this->router->pathFor($name, $params);
	}
}