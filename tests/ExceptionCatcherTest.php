<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\JsonDecoder;

class ExceptionCatcherTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Filchos\Imago\Exception\FormatException
     * @expectedExceptionMessage invalid json
     */
    public function testWithout()
    {
        $json  = '["city":]';
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\JsonDecoder');
        $imago->get();
    }

    public function testWithBackstop()
    {
        $json  = '["city":]';
        $imago = (new Value($json))
            ->to('Filchos\\Imago\\Transformer\\JsonDecoder')
            ->to('Filchos\\Imago\\Transformer\\ExceptionCatcher')
        ;
        $this->assertNull($imago->get());
        $this->assertTrue($imago->meta()->has('exception'));
        $exception = $imago->meta()->get('exception');
        $this->assertInstanceOf('Filchos\\Imago\\Exception\\FormatException', $exception);
        $this->assertSame('invalid json', $exception->getMessage());
    }

    public function testWithAlternative()
    {
        $json  = '["city":]';
        $imago = (new Value($json))
            ->to('Filchos\\Imago\\Transformer\\JsonDecoder')
            ->to('Filchos\\Imago\\Transformer\\ExceptionCatcher', ['onError' => 'NO JSON'])
        ;
        $this->assertSame('NO JSON', $imago->get());
    }

    public function testWithCallableAlternative()
    {
        $callback = function () {
            return 'Really no json';
        };
        $json  = '["city":]';
        $imago = (new Value($json))
            ->to('Filchos\\Imago\\Transformer\\JsonDecoder')
            ->to('Filchos\\Imago\\Transformer\\ExceptionCatcher', ['onError' => $callback])
        ;
        $this->assertSame('Really no json', $imago->get());
    }
}
