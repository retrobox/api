<?php

class PublishOrderEventTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected static $container;

    public static function setUpBeforeClass()
    {
        self::$container = Setup::get();
    }

    public function testPublishOrderPayedPublishEvent()
    {
        $published = self::$container->get(\Lefuturiste\RabbitMQPublisher\Client::class)
            ->publish(['id' => "5ba61d8f30e7a"], 'order.payed');
        $this->assertEquals($published, true);
    }

    public function testPublishOrderShippedPublishEvent()
    {
        $published = self::$container->get(\Lefuturiste\RabbitMQPublisher\Client::class)
            ->publish(['id' => "5ba61d8f30e7a"], 'order.shipped');
        $this->assertEquals($published, true);
    }
}