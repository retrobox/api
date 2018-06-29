<?php

namespace App\Auth;

use Carbon\Carbon;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Firebase\JWT\JWT;

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
	 * @var Container
	 */
	private $container;

	public function __construct(Container $container)
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
        try {
            $jwt = JWT::encode([
                'iss' => $this->container->get('app_name') . '._.' . $this->container->get('env_name'),
                'iat' => Carbon::now()->timestamp,
                'user' => $user
            ], $this->container->get('jwt')['key']);

            return $jwt;
        } catch (DependencyException $e) {
        } catch (NotFoundException $e) {
        }
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
}