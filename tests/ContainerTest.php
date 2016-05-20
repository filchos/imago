<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Container;
use Filchos\Imago\Source\Value;

class ContainerTest extends PHPUnit_Framework_TestCase
{

    public function testInstance()
    {
        $container = new Container;
        $this->assertInstanceOf('Filchos\\Imago\\Container', $container);
    }

    public function testAll()
    {
        $container = $this->getContainer();
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten'];
        $this->assertSame($should, $container->all());
    }

    public function testGet()
    {
        $container = $this->getContainer();
        $this->assertSame('Skellefteå', $container->get('city'));
        $this->assertSame('Västerbotten', $container->get('region'));
        $this->assertNull($container->get('country'));
        $this->assertSame('Sverige', $container->get('country', 'Sverige'));
    }

    public function testHas()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->has('city'));
        $this->assertFalse($container->has('country'));
    }

    public function testSet()
    {
        $container = $this->getContainer();
        $container->set('country', 'Sverige');
        $this->assertTrue($container->has('country'));
        $this->assertSame('Sverige', $container->get('country'));
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten', 'country' => 'Sverige'];
        $this->assertSame($should, $container->all());
    }

    public function testSetUnlessExists()
    {
        $container = $this->getContainer();
        $container->setUnlessExists('country', 'Sverige');
        $this->assertSame('Sverige', $container->get('country'));
        $container->setUnlessExists('region', 'Norra Norrland');
        $this->assertSame('Västerbotten', $container->get('region'));
    }

    public function testDelete()
    {
        $container = $this->getContainer();
        $container->delete('region');
        $this->assertFalse($container->has('region'));
        $should = ['city' => 'Skellefteå'];
        $this->assertSame($should, $container->all());
    }

    protected function getContainer()
    {
        return new Container(['city' => 'Skellefteå', 'region' => 'Västerbotten']);
    }
}
