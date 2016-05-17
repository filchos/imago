<?php

require_once __DIR__ . '/../vendor/autoload.php';

class UnitTest extends PHPUnit_Framework_TestCase
{

    public function testLocal()
    {
        $value = 'Skelleftehamn';
        $this->assertSame('Skelleftehamn', $value);
    }

    public function testServer()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/unit-test-server.txt');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $value = curl_exec($ch);
        curl_close($ch);
        $this->assertSame('Gåsören', $value);
    }

}
