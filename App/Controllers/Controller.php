<?php
namespace App\Controllers;

use Illuminate\Database\Capsule\Manager;
use Predis\Client;
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

    /**
     * Load the database by loading the ORM manager from the container
     */
	public function loadDatabase(): void
    {
        $this->container->get(Manager::class);
    }

    public function redis(): Client
    {
        return $this->container->get(Client::class);
    }
}
