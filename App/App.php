<?php

namespace App;

use App\Utils\ContainerBuilder;

class App extends \DI\Bridge\Slim\App
{
    /**
     * The absolute fs path of the root of the application
     *
     * @var string
     */
    private static $basePath = '';

    public function __construct()
    {
        parent::__construct();

        $this->add(new Middlewares\CorsMiddleware());

        $this->get('/', [Controllers\PagesController::class, 'getHome']);
        $this->get('/ping', [Controllers\PagesController::class, 'getPing']);
        $this->map(['POST', 'OPTIONS'], '/newsletter/subscribe', [Controllers\NewsletterController::class, 'postSubscribe']);
        $this->get('/newsletter/event', [Controllers\NewsletterController::class, 'getEvent']);
        $this->post('/newsletter/event', [Controllers\NewsletterController::class, 'postEvent']);

        $this->map(['POST','OPTIONS'], '/graphql', [Controllers\GraphQlController::class, 'newRequest'])
            ->add(new Middlewares\JWTMiddleware($this->getContainer()));

        //Routes deprecated
        /*$this->get('/paysafecard/get_url', [Controllers\Payment\PaysafeCardController::class, 'getUrl']);
        $this->post('/paysafecard/capture_payment', [Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
        $this->get('/paysafecard/success', [Controllers\Payment\PaysafeCardController::class, 'getSuccess']);
        $this->get('/paysafecard/failure', [Controllers\Payment\PaysafeCardController::class, 'getFailure']);*/
        $this->map(['POST','OPTIONS'], '/stripe/execute', [Controllers\Payment\StripeController::class, 'postExecute'])
            ->add(new Middlewares\JWTMiddleware($this->getContainer()));
        $this->map(['POST','OPTIONS'], '/paypal/get-url', [Controllers\Payment\PaypalController::class, 'postGetUrl'])
            ->add(new Middlewares\JWTMiddleware($this->getContainer()));
        $this->get('/paypal/execute', [Controllers\Payment\PaypalController::class, 'postExecute']);

        $this->group('/account', function (){
            $this->get('/login', [Controllers\AccountController::class, 'getLogin']);
            $this->get('/register', [Controllers\AccountController::class, 'getLogin']);
            $this->get('/login-desktop', [Controllers\AccountController::class, 'getLoginDesktop']);
            $this->post('/login-desktop', [Controllers\AccountController::class, 'postLoginDesktop'])
                ->add(new Middlewares\JWTMiddleware($this->getContainer()));

            $this->map(['GET', 'OPTIONS'], '/info', [Controllers\AccountController::class, 'getInfo'])
                ->add(new Middlewares\JWTMiddleware($this->getContainer()));

            $this->map(['GET', 'POST', 'OPTIONS'], '/execute', [Controllers\AccountController::class, 'execute'])
                ->add(new \RKA\Middleware\IpAddress());
        });

        $this->group('/dashboard', function () {
            $this->map(['GET', 'OPTIONS'], '[/]', [Controllers\DashboardController::class, 'getDashboard']);
            $this->map(['POST', 'OPTIONS'], '/upload', [Controllers\UploadController::class, 'postUpload']);
            $this->map(['GET', 'OPTIONS'], '/delete', [Controllers\DashboardController::class, 'getDelete']);
        })->add(new Middlewares\JWTMiddleware($this->getContainer()));

        $this->group('/shop', function () {
            $this->get('/storage-prices', [Controllers\ShopController::class, 'getStoragePrices']);
            $this->get('/shipping-prices', [Controllers\ShopController::class, 'getShippingPrices']);
            $this->get('/{locale}/categories', [Controllers\ShopController::class, 'getCategories']);
            $this->get('/{locale}/item/{slug}', [Controllers\ShopController::class, 'getItem']);
        });

        $this->post('/console/verify', [Controllers\ConsoleController::class, 'verifyConsole']);

        $this->get('/downloads', [Controllers\DownloadController::class, 'getDownloads']);

        $this->group('/docs', function (){
            $this->get('/{locale}/{slug}', [Controllers\DocsController::class, 'getPage']);
        });

        $this->get('/websocket/connexions', [Controllers\PagesController::class, 'getWebSocketConnexions'])
            ->add(new Middlewares\JWTMiddleware($this->getContainer()));
        $this->get('/test-send-email-event', [Controllers\PagesController::class, 'testSendEmailEvent'])
            ->add(new Middlewares\JWTMiddleware($this->getContainer()));

        $this->get('/countries/{locale}', [Controllers\CountriesController::class, 'getCountries']);

        $this->get('/health', [Controllers\HealthController::class, 'getHealth']);
    }

    protected function configureContainer(\DI\ContainerBuilder $builder)
    {
        ContainerBuilder::getContainerBuilder($builder);
    }

    public static function setBasePath(string $basePath): void
    {
        self::$basePath = $basePath;
    }

    public static function getBasePath(): string
    {
        return self::$basePath;
    }
}
