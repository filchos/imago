<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\FirstOf;

class FirstOfTest extends PHPUnit_Framework_TestCase
{

    public function testFirstOk()
    {
        $imago1 = new Value('Pajala');
        $imago2 = new ExceptionThrower;
        $imago  = (new FirstOf($imago1))->otherwise($imago2);
        $value  = $imago->get();
        $this->assertSame('Pajala', $value);
    }

    public function testSecondOk()
    {
        $imago1 = new ExceptionThrower;
        $imago2 = new Value('Pajala');
        $imago  = (new FirstOf($imago1))->otherwise($imago2);
        $value  = $imago->get();
        $this->assertSame('Pajala', $value);
    }

    public function testInner()
    {
        $imago1 = new ExceptionThrower;
        $imago2 = new Value('Pajala');
        $imago  = (new FirstOf($imago1))->otherwise($imago2);
        $this->assertNull($imago->inner());
        $imago->get();
        $this->assertInstanceOf('Filchos\\Imago\\Source\\Value', $imago->inner());
        $this->assertSame('Pajala', $imago->inner()->options()->get('value'));
    }

    public function testBothOkFirstWins()
    {
        $imago1 = new Value('Skellefteå');
        $imago2 = new Value('Umeå');
        $imago  = (new FirstOf($imago1))->otherwise($imago2);
        $value  = $imago->get();
        $this->assertSame('Skellefteå', $value);
    }

    /**
     * @expectedException Filchos\Imago\Exception\FirstOfException
     */
    public function testNoneOk()
    {
        $imago1 = new ExceptionThrower;
        $imago2 = new ExceptionThrower;
        $imago  = (new FirstOf($imago1))->otherwise($imago2);
        $imago->get();
    }
}

class ExceptionThrowException extends Exception
{
}

class ExceptionThrower extends AbstractSource
{

    public function get()
    {
        throw new ExceptionThrowException;
    }
}
