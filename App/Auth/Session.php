<?php

namespace App\Auth;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;

class Session
{

  /**
   * Raw JSON Web token sent by the client
   *
   * @var string
   */
  private string $token;

  /**
   * Data decoded contained inside the JWT
   *
   * @var array
   */
  private array $data;

  /**
   * @var ContainerInterface
   */
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * Create the session and return the JWT
   *
   * @param $user
   * @return string
   */
  public function create($user): string
  {
    return JWT::encode([
      'iss' => $this->container->get('app_name') . '._.' . $this->container->get('env_name'),
      'iat' => Carbon::now()->timestamp,
      'user' => $user
    ], $this->container->get('jwt')['key']);
  }

  /**
   * Return array about actual user logged in
   *
   * @return array
   */
  public function getUser(): array
  {
    return $this->data['user'];
  }

  /**
   * Return session user id
   *
   * @return string
   */
  public function getUserId(): string
  {
    if (isset($this->data['user']['id'])) {
      return $this->data['user']['id'];
    }
    return "";
  }

  /**
   * Get the actual raw JWT
   *
   * @return string
   */
  public function getToken(): string
  {
    return $this->token;
  }

  /**
   * Set token payload for this session
   *
   * @param array $data
   */
  public function setData(array $data)
  {
    $this->data = $data;
  }

  /**
   * Set raw JWT for this session
   *
   * @param string $token
   */
  public function setToken(string $token)
  {
    $this->token = $token;
  }

  /**
   * @return array
   */
  public function getData(): array
  {
    return $this->data;
  }

  /**
   * @return boolean
   */
  public function isAdmin(): bool
  {
    return (bool)$this->data['user']['is_admin'];
  }
}
