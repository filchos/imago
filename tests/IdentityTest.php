<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\Identity;

class IdentityTest extends PHPUnit_Framework_TestCase
{

    public function testClass()
    {
        $imago = new Value('Abisko');
        $imago = new Identity($imago);
        $this->assertInstanceOf('Filchos\\Imago\\Transformer\\AbstractTransformer', $imago);
        $this->assertInstanceOf('Filchos\\Imago\\Transformer\\Identity', $imago);
    }

    public function testGet()
    {
        $random = rand();
        $imago = new Value($random);
        $imago = new Identity($imago);
        $this->assertSame($random, $imago->get());
    }
}
