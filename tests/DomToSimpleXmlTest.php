<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\DomToSimpleXml;
use Filchos\Imago\Transformer\XmlToDom;

class DomToSimpleXmlTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $xml    = '<root><item>Kåge</item><item>Byske</item><item>Tåme</item></root>';
        $imago  = new Value($xml);
        $imago  = new XmlToDom($imago);
        $imago  = new DomToSimpleXml($imago);
        $simple = $imago->get();
        $this->assertInstanceOf('SimpleXMLElement', $simple);
        $this->assertEquals(3, count($simple->item));
        $this->assertEquals('Tåme', (string) $simple->item[2]);
        $this->assertEquals('root', $simple->getName());
    }

    /**
     * @expectedException Filchos\Imago\Exception\AcceptException
     */
    public function testWrongInputType()
    {
        $xml   = ['not', 'a', 'string'];
        $imago = (new Value($xml))->to('Filchos\\Imago\\Transformer\\DomToSimpleXml');
        $imago->get();
    }
}
