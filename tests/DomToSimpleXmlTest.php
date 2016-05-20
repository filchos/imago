<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\DomToSimpleXml;
use Filchos\Imago\Transformer\HtmlToDom;
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
        $this->assertSame(3, count($simple->item));
        $this->assertEquals('Tåme', $simple->item[2]);
        $this->assertSame('Tåme', (string) $simple->item[2]);
        $this->assertSame('root', $simple->getName());
    }

    public function testUglyHtmlGet()
    {
        $html    = '<li>Innervik<li>Yttervik<li>Bureå<li>Burvik';
        $imago  = new Value($html);
        $imago  = new HtmlToDom($imago);
        $imago  = new DomToSimpleXml($imago);
        $simple = $imago->get();
        $list   = $simple->xpath('//li');
        $this->assertEquals(4, count($list));
        $this->assertEquals('Bureå', $list[2]);
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
