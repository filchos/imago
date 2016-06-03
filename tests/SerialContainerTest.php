<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Container\LocalSerialContainer;
use Filchos\Imago\Source\Value;

class SerialContainerTest extends PHPUnit_Framework_TestCase
{

    public function testNext()
    {
        $container = $this->getContainer();
        $this->assertSame($container->get('city'), $container->next()->get('city'));
    }

    public function testGet()
    {
        $container = $this->getContainer();
        $this->assertSame('Skellefteå', $container->get('city'));
        $this->assertSame('Västerbotten', $container->get('region'));
        $this->assertSame('Sverige', $container->get('country'));
        $this->assertSame('Europe', $container->get('continent', 'Europe'));

        $this->assertNull($container->getOwn('city', null));
        $this->assertNull($container->getOwn('region', null));
        $this->assertSame('Sverige', $container->getOwn('country'));
        $this->assertSame('Europa', $container->getOwn('continent', 'Europa'));
    }

    public function testFirstWins()
    {
        $container = $this->getContainer();
        $this->assertSame('Skellefteå', $container->get('city'));
        $container->set('city', 'Skelleftehamn');
        $this->assertSame('Skelleftehamn', $container->get('city'));
        $container->delete('city');
        $this->assertSame('Skellefteå', $container->get('city'));
    }

    /**
     * @expectedException Filchos\Imago\Exception\MissingKeyException
     */
    public function testGetInvalid()
    {
        $container = $this->getContainer();
        $container->get('continent');
    }

    public function testHas()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->has('city'));
        $this->assertTrue($container->has('region'));
        $this->assertTrue($container->has('country'));
        $this->assertFalse($container->has('continent'));

        $this->assertFalse($container->hasOwn('city'));
        $this->assertFalse($container->hasOwn('region'));
        $this->assertTrue($container->hasOwn('country'));
        $this->assertFalse($container->hasOwn('continent'));
    }

    public function testSet()
    {
        $container = $this->getContainer();
        $container->set('continent', 'Europa');
        $this->assertSame('Europa', $container->get('continent'));
        $this->assertSame('Europa', $container->getOwn('continent'));
        $this->assertNull($container->next()->get('continent', null));
    }

    public function testDelete()
    {
        $container = $this->getContainer();
        $container->delete('country');
        $this->assertNull($container->get('country', null));
        $container->delete('city');
        $this->assertSame('Skellefteå', $container->get('city'));
    }

    protected function getContainer()
    {
        $inner = new LocalSerialContainer(['city' => 'Skellefteå', 'region' => 'Västerbotten']);
        $outer = new LocalSerialContainer(['country' => 'Sverige']);
        $outer->setNext($inner);
        return $outer;
    }
}
