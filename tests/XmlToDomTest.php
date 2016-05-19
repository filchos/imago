<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\XmlToDom;

class XmlToDomTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $json  = '<root><item>one</item><item>two</item><item>three</item></root>';
        $imago = new Value($json);
        $imago = new XmlToDom($imago);
        $doc   = $imago->get();
        $this->assertInstanceOf('DomDocument', $doc);
        $this->assertEquals(3, $doc->getElementsByTagName('item')->length);
        $this->assertEquals('root', $doc->documentElement->nodeName);
    }

    /**
     * @expectedException Filchos\Imago\Exception\EmptyException
     */
    public function testEmpty()
    {
        $json  = '';
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\XmlToDom');
        $imago->get();
    }

    /**
     * @expectedException Filchos\Imago\Exception\DomException
     * @expectedExceptionCode 76
     */
    public function testInvalid76()
    {
        $json  = '<open></close>';
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\XmlToDom');
        $imago->get();
    }

    /**
     * @expectedException Filchos\Imago\Exception\DomException
     * @expectedExceptionCode 77
     */
    public function testInvalid77()
    {
        $json  = '<two><open-tags>';
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\XmlToDom');
        $imago->get();
    }

    /**
     * @expectedException Filchos\Imago\Exception\AcceptException
     */
    public function testWrongInputType()
    {
        $json = ['not', 'a', 'string'];
        $imago = (new Value($json))->to('Filchos\\Imago\\Transformer\\XmlToDom');
        $imago->get();
    }

}
