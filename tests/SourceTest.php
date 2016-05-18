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
        $this->assertSame($should, $options->all());
        $this->assertSame('Skellefteå', $options->get('city'));
        $this->assertSame($imago, $options->owner());
    }

    public function testMetaContainer()
    {
        $imago = new MetaSource;
        $meta  = $imago->meta();
        $this->assertInstanceOf('Filchos\\Imago\\Container', $meta);
        $this->assertSame([], $meta->all());
        $this->assertSame($imago, $meta->owner());

        $imago->get();
        $meta  = $imago->meta();
        $should = ['inited' => true];
        $this->assertSame($should, $meta->all());
        $this->assertTrue($meta->get('inited'));
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

class MetaSource extends AbstractSource
{

    public function get()
    {
        $this->meta()->set('inited', true);
    }
}
