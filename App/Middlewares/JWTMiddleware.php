<?php

namespace App\Middlewares;

use App\Auth\Session;
use DI\Container;
use function DusanKasan\Knapsack\toArray;
use Firebase\JWT\JWT;
use Noodlehaus\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JWTMiddleware
{
	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var Session|mixed
	 */
	private $session;

	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->session = $container->get(Session::class);
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
	{
		if ($request->hasHeader('Authorization')) {
			$token = str_replace('Bearer ', '', $request->getHeader('Authorization'))[0];
			try {
				$decoded = JWT::decode($token, $this->container->get('jwt')['key'], ['HS256']);
			} catch (\Exception $e) {
				return $response->withStatus(401)->withJson([
					'success' => false,
					'errors' => [
						[
							'message' => 'Authorization header is invalid : invalid token',
							'code' => 'auth_header_invalid'
						]
					]
				]);
			}
			$this->session->setData(json_decode(json_encode($decoded), 1));
			$this->session->setToken($token);
			return $next($request, $response);
		} else {
			return $response->withStatus(401)->withJson([
				'success' => false,
				'errors' => [
					[
						'message' => 'Authorization header is missing',
						'code' => 'auth_header_missing'
					]
				]
			]);
		}
	}
}