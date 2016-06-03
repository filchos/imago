<?php

require_once __DIR__ . '/../vendor/autoload.php';

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
        $this->assertInstanceOf('Filchos\\Imago\\Container\\LocalSerialContainer', $options);
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten'];
        $this->assertSame($should, $options->all());
        $this->assertSame('Skellefteå', $options->get('city'));
    }

    public function testIndependentOptionContainerOnClone()
    {
        $imago1 = new OptionSource(['city' => 'Kurravaara']);
        $imago2 = clone $imago1;
        $this->assertSame('Kurravaara', $imago2->options()->get('city'));
        $imago2->options()->set('city', 'Jukkasjärvi');
        $this->assertSame('Kurravaara', $imago1->options()->get('city'));
    }

    public function testMetaContainer()
    {
        $imago = new MetaSource;
        $meta  = $imago->meta();
        $this->assertInstanceOf('Filchos\\Imago\\Container\\LocalSerialContainer', $meta);
        $this->assertSame([], $meta->all());

        $imago->get();
        $meta  = $imago->meta();
        $should = ['inited' => true];
        $this->assertSame($should, $meta->all());
        $this->assertTrue($meta->get('inited'));
    }
}
