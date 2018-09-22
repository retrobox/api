<?php

namespace App\Middlewares;

use App\Auth\Session;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class JWTMiddleware
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var Session|mixed
	 */
	private $session;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
        $this->session = $container->get(Session::class);
    }

	public function __invoke(ServerRequestInterface $request, Response $response, $next)
	{
		if ($request->hasHeader('Authorization')) {
			$token = str_replace('Bearer ', '', $request->getHeader('Authorization'))[0];
			//master api key bypass
			if ($token === $this->container->get('master_api_key')){
			    $this->session->setData(['user' => ['is_admin' => true]]);
                return $next($request, $response);
            }
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