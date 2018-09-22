<?php

namespace App\Auth;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;

class Session
{

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var ContainerInterface
	 */
	private $container;

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
	public function create($user) : string
	{
        $jwt = JWT::encode([
            'iss' => $this->container->get('app_name') . '._.' . $this->container->get('env_name'),
            'iat' => Carbon::now()->timestamp,
            'user' => $user
        ], $this->container->get('jwt')['key']);

        return $jwt;
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
        return $this->data['user']['id'];
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
        return (boolean)$this->data['user']['is_admin'];
    }
}