<?php

namespace Test\MockTest;

use Test\Wrapper;

class SlimTest extends Wrapper
{
    public function testMainApiPage()
    {
        $this->beforeTest();
        $response = $this->generate(
            $this->getRequest('GET', '/')
        );
        $this->assertEquals(200, $response->getStatusCode());
        $json = $this->parseJsonResponse($response);
        $this->assertEquals([
            'success' => true,
            'data' => [
                'name' => self::$container->get('app_name'),
                'env' => self::$container->get('env_name')
            ]
        ], $json);
    }
}
