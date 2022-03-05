<?php /** @noinspection PhpDocMissingThrowsInspection */

namespace App\Utils;

use App\JsonWhoopsResponseHandler;
use Psr\Container\ContainerInterface;
use Slim\App;
use function Sentry\captureException;

class WhoopsGuard
{
    /**
     * Setup WhoopsGuard, regardless of the environment (dev or prod) WhoopsGuard is always setup:
     * - In production, you will get only a simple JSON output
     * - Whereas in development you will get the full details with a web interface
     *
     * @param App $app
     * @param ContainerInterface $container
     */
    public static function load(App $app, ContainerInterface $container): void
    {
        $whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
        $whoopsGuard->setApp($app);
        $whoopsGuard->setRequest($container->get('request'));
        $handlers = [];
        if (boolval(getenv('SENTRY_ENABLE')))
            $handlers[] = fn($e) => captureException($e);
        if (!boolval(getenv('APP_DEBUG')))
            $handlers[] = new JsonWhoopsResponseHandler();
        $whoopsGuard->setHandlers($handlers);
        $whoopsGuard->install();
    }
}

