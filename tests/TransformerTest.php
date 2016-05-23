<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;

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
        $this->assertInstanceOf('Filchos\\Imago\\Source\\Value', $imago->inner());
    }

    public function testOptionsThroughConstructor()
    {
        $imago = new Value('Abisko');
        $imago = new Repeater($imago, ['repeat' => 3]);
        $this->assertSame(3, $imago->options()->get('repeat'));
        $this->assertSame('AbiskoAbiskoAbisko', $imago->get());
    }

    public function testOptionsThroughSetter()
    {
        $imago = new Value('Piteå');
        $imago = new Repeater($imago);
        $imago->options()->set('repeat', 4);
        $this->assertSame(4, $imago->options()->get('repeat'));
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
        $this->assertSame(3, $imago->options()->get('repeat'));
        $this->assertSame('PiteåPiteåPiteå', $imago->get());
    }

    public function testChainingWithOptionThroughSetter()
    {
        $imago = (new Value('Piteå'))->to('Repeater');
        $imago->options()->set('repeat', 3);
        $this->assertSame(3, $imago->options()->get('repeat'));
        $this->assertSame('PiteåPiteåPiteå', $imago->get());
    }
}
