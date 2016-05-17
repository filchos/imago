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
        $this->assertSame($should, $imago->getOptions());
    }

    public function testGetOption()
    {
        $imago = $this->getOptionImago();
        $this->assertSame('Skellefteå', $imago->getOption('city'));
        $this->assertSame('Västerbotten', $imago->getOption('region'));
        $this->assertNull($imago->getOption('country'));
        $this->assertSame('Sverige', $imago->getOption('country', 'Sverige'));
    }

    public function testHasOption()
    {
        $imago = $this->getOptionImago();
        $this->assertTrue($imago->hasOption('city'));
        $this->assertFalse($imago->hasOption('country'));
    }

    public function testSetOption()
    {
        $imago = $this->getOptionImago();
        $imago->setOption('country', 'Sverige');
        $this->assertTrue($imago->hasOption('country'));
        $this->assertSame('Sverige', $imago->getOption('country'));
        $should = ['city' => 'Skellefteå', 'region' => 'Västerbotten', 'country' => 'Sverige'];
        $this->assertSame($should, $imago->getOptions());
    }

    public function testDeleteOption()
    {
        $imago = $this->getOptionImago();
        $imago->deleteOption('region');
        $this->assertFalse($imago->hasOption('region'));
        $should = ['city' => 'Skellefteå'];
        $this->assertSame($should, $imago->getOptions());
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
