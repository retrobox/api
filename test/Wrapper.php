<?php

namespace Test;

use App\App;
use App\Utils\ContainerBuilder;
use App\Utils\DotEnv;
use Invoker\InvokerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class Wrapper extends TestCase
{
    /**
     * @var ContainerInterface|InvokerInterface
     */
    protected static $container;
    protected static array $store = [];

    public function beforeTest() {
        putenv("_UNIT_TEST=1");
        App::setBasePath(dirname(__DIR__));
        DotEnv::load();
        self::$container = ContainerBuilder::direct();
    }

    protected function getRequest(string $method, string $uri, string $queryString = ""): Request
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $uri,
            'QUERY_STRING' => $queryString
        ]);

        return Request::createFromEnvironment($env);
    }

    protected function generate(ServerRequestInterface $request): ResponseInterface
    {
        $app = new App();
        return $app->callMiddlewareStack($request, new Response());
    }

    public function parseJsonResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->__toString(), 1);
    }
}
