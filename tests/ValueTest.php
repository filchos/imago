<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;

class ValueTestTest extends PHPUnit_Framework_TestCase
{

    public function testClass()
    {
        $imago = new Value('Åsele');
        $this->assertInstanceOf('Filchos\\Imago\\Source\\AbstractSource', $imago);
        $this->assertInstanceOf('Filchos\\Imago\\Source\\Value', $imago);
    }

    public function testGet()
    {
        $imago = new Value(['Åsele', 'Fredrika']);
        $this->assertSame(['Åsele', 'Fredrika'], $imago->get());
        $this->assertSame(['Åsele', 'Fredrika'], $imago());
    }

}
