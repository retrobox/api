<?php

include 'setup.php';

class PaymentManagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected static $container;

    public static function setUpBeforeClass()
    {
        self::$container = Setup::get();
    }

    public function testGetTotal()
    {
        $items = [
            [
                "id" => "5b598775e8e22"
            ]
        ];
        self::$container->get(\Illuminate\Database\Capsule\Manager::class);
        $paymentManager = new \App\PaymentManager($items, self::$container);
        $this->assertInternalType('float', $paymentManager->getSubTotalPrice());
        $this->assertGreaterThan(0, $paymentManager->getSubTotalPrice());
        $this->assertInternalType('float', $paymentManager->getTotalShippingPrice());
        $this->assertGreaterThan(0, $paymentManager->getTotalShippingPrice());
        $this->assertInternalType('float', $paymentManager->getTotalPrice());
        $this->assertGreaterThan(0, $paymentManager->getTotalShippingPrice());
    }
}