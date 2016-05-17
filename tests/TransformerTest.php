<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\AbstractTransformer;

class TransformerTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $imago = new Value('Abisko');
        $imago = new Repeater($imago);
        $this->assertSame('AbiskoAbisko', $imago->get());
    }

    public function testInner()
    {
        $imago = new Value('Abisko');
        $imago = new Repeater($imago);
        $this->assertInstanceOf('Filchos\\Imago\\Source\\Value', $imago->getInner());
    }

    public function testOptionsThroughConstructor()
    {
        $imago = new Value('Abisko');
        $imago = new Repeater($imago, ['repeat' => 3]);
        $this->assertSame(3, $imago->getOption('repeat'));
        $this->assertSame('AbiskoAbiskoAbisko', $imago->get());
    }

    public function testOptionsThroughSetter()
    {
        $imago = new Value('Piteå');
        $imago = new Repeater($imago);
        $imago->setOption('repeat', 4);
        $this->assertSame(4, $imago->getOption('repeat'));
        $this->assertSame('PiteåPiteåPiteåPiteå', $imago->get());
    }

    public function testChaining()
    {
        $imago = (new Value('Piteå'))->to('Repeater');
        $this->assertSame('PiteåPiteå', $imago->get());
    }

    public function testChainingWithToOption()
    {
        $imago = (new Value('Piteå'))->to('Repeater', ['repeat' => 3]);
        $this->assertSame(3, $imago->getOption('repeat'));
        $this->assertSame('PiteåPiteåPiteå', $imago->get());
    }

    public function testChainingWithOptionThroughSetter()
    {
        $imago = (new Value('Piteå'))->to('Repeater');
        $imago->setOption('repeat', 3);
        $this->assertSame(3, $imago->getOption('repeat'));
        $this->assertSame('PiteåPiteåPiteå', $imago->get());
    }
}

class Repeater extends AbstractTransformer
{

    public function transform($string)
    {
        $multiplier = (int) $this->getOption('repeat', 2);
        return str_repeat($string, $multiplier);
    }
}
