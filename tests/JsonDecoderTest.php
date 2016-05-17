<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\JsonDecoder;

class JsonDecoderTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $json  = json_encode(['city' => 'Gällivare']);
        $imago = new Value($json);
        $imago = new JsonDecoder($imago);
        $should = (object) ['city' => 'Gällivare'];
        $this->assertEquals($should, $imago->get());
    }

    /**
     * @expectedException Filchos\Imago\Exception\FormatException
     * @expectedExceptionMessage invalid json
     */
    public function testInvalid()
    {
        $json  = '["city":]';
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\JsonDecoder');
        $imago->get();
    }
}
