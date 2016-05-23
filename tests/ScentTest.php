<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\Identity;
use Filchos\Imago\Transformer\JsonDecoder;

class ScentTest extends PHPUnit_Framework_TestCase
{

    public function testSource()
    {
        $imago  = new OptionSource(['city' => 'Nattavaara']);
        $should = 'OptionSource({"city":"Nattavaara"})';
        $this->assertSame($should, $imago->scent());
    }

    public function testTransformer()
    {
        $json   = json_encode(['city' => 'Nattavaara']);
        $imago  = new Value($json);
        $imago  = new Identity($imago);
        $imago  = new JsonDecoder($imago);
        $should = implode("\n", [
            'Filchos\\Imago\\Source\\Value({"value":"{\"city\":\"Nattavaara\"}"})',
            'Filchos\\Imago\\Transformer\\Identity({})',
            'Filchos\\Imago\\Transformer\\JsonDecoder({})',
        ]);
        $this->assertSame($should, $imago->scent());
    }

}
