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

    public function testGetOptions()
    {
        $imago = $this->getOptionImago();
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten'];
        $this->assertSame($should, $imago->options()->all());
    }

    public function testGetOption()
    {
        $imago = $this->getOptionImago();
        $this->assertSame('Skellefteå', $imago->options()->get('city'));
        $this->assertSame('Västerbotten', $imago->options()->get('region'));
        $this->assertNull($imago->options()->get('country'));
        $this->assertSame('Sverige', $imago->options()->get('country', 'Sverige'));
    }

    public function testHasOption()
    {
        $imago = $this->getOptionImago();
        $this->assertTrue($imago->options()->has('city'));
        $this->assertFalse($imago->options()->has('country'));
    }

    public function testSetOption()
    {
        $imago = $this->getOptionImago();
        $imago->options()->set('country', 'Sverige');
        $this->assertTrue($imago->options()->has('country'));
        $this->assertSame('Sverige', $imago->options()->get('country'));
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten', 'country' => 'Sverige'];
        $this->assertSame($should, $imago->options()->all());
    }

    public function testDeleteOption()
    {
        $imago = $this->getOptionImago();
        $imago->options()->delete('region');
        $this->assertFalse($imago->options()->has('region'));
        $should = ['city' => 'Skellefteå'];
        $this->assertSame($should, $imago->options()->all());
    }

    protected function getOptionImago()
    {
        return new OptionSource(['city' => 'Skellefteå', 'region' => 'Västerbotten']);
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
