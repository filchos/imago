<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\AbstractSource;

class ScourceTest extends PHPUnit_Framework_TestCase
{

    public function testClass()
    {
        $imago = new JokkmokkSource;
        $this->assertInstanceOf('Filchos\\Imago\\Source\\AbstractSource', $imago);
    }

    public function testGet()
    {
        $imago = new JokkmokkSource;
        $this->assertSame('Jokkmokk', $imago->get());
        $this->assertSame('Jokkmokk', $imago());
    }

    public function testOptionContainer()
    {
        $imago   = new OptionSource(['city' => 'Skellefteå', 'region' => 'Västerbotten']);
        $options = $imago->options();
        $this->assertInstanceOf('Filchos\\Imago\\Container', $options);
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten'];
        $this->assertSame($should, $imago->options()->all());
        $this->assertSame($imago, $imago->options()->owner());
    }

}

class JokkmokkSource extends AbstractSource
{

    public function get()
    {
        return 'Jokkmokk';
    }
}

class OptionSource extends AbstractSource
{

    public function get()
    {
        return null;
    }
}
