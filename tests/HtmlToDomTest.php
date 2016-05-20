<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\Value;
use Filchos\Imago\Transformer\HtmlToDom;

class HtmlToDomTest extends PHPUnit_Framework_TestCase
{

    public function testGetWellFormed()
    {
        $xml   = '<body><h1>Malmberget</h1></body>';
        $imago = new Value($xml);
        $imago = new HtmlToDom($imago);
        $doc   = $imago->get();

        $this->assertInstanceOf('DomDocument', $doc);
        $this->assertEquals('Malmberget', $doc->getElementsByTagName('h1')->item(0)->nodeValue);
    }

    public function testUgly()
    {
        $xml   = '<p><h2>Koskullskulle';
        $imago = new Value($xml);
        $imago = new HtmlToDom($imago);
        $doc   = $imago->get();

        $this->assertInstanceOf('DomDocument', $doc);
        $this->assertEquals('Koskullskulle', $doc->getElementsByTagName('h2')->item(0)->nodeValue);
    }

    /**
     * @expectedException Filchos\Imago\Exception\DomException
     * @expectedExceptionCode 81
     */
    public function testWrongIso()
    {
        $xml   = '<h3>G' . chr(228) . 'llivare</h3>';
        $imago = new Value($xml);
        $imago = new HtmlToDom($imago);
        $doc   = $imago->get();
    }

    public function testCorrectedIso1()
    {
        $xml   = '<h3>G' . chr(228) . 'llivare</h3>';
        $imago = new Value($xml);
        $imago = new HtmlToDom($imago, ['encoding' => 'ISO-8859-15']);
        $doc   = $imago->get();

        $this->assertSame('ISO-8859-15', $imago->options()->get('encoding'));
        $this->assertEquals('Gällivare', $doc->getElementsByTagName('h3')->item(0)->nodeValue);
    }

    public function testCorrectedIso5()
    {
        $xml   = '<h4>' . chr(191) . chr(208) . chr(239) . chr(219) . chr(208). '</h4>';
        $imago = new Value($xml);
        $imago = new HtmlToDom($imago, ['encoding' => 'ISO-8859-5']);
        $doc   = $imago->get();

        $this->assertEquals('Паяла', $doc->getElementsByTagName('h4')->item(0)->nodeValue);
    }
}
