<?php

namespace App\Controllers;

use App\Auth\Session;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client as JobatatorClient;
use Predis\Client;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

use function DusanKasan\Knapsack\contains;

class Controller
{

  /**
   * @var ContainerInterface
   */
  protected ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * @param ResponseInterface $response
   * @param $location
   * @return ResponseInterface
   */
  public function redirect(ResponseInterface $response, $location)
  {
    return $response->withStatus(302)->withHeader('Location', $location);
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

  public function session(): Session
  {
    return $this->container->get(Session::class);
  }

  public function jobatator(): JobatatorClient
  {
    return $this->container->get(JobatatorClient::class);
  }

  public function json(ResponseInterface $response, $data = ['success' => true], $status = 200,): ResponseInterface
  {
    $response->getBody()->write(json_encode($data));
    return $response->withStatus($status);
  }
}
