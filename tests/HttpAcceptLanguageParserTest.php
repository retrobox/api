<?php

class HttpAcceptLanguageParserTest extends \PHPUnit\Framework\TestCase {
    public function testLocaleParser() {
        $this->assertEquals('fr', \Teto\HTTP\AcceptLanguage::get("fr,en;q=0.7,en-US;q=0.3")[0]['language']);
    }
}