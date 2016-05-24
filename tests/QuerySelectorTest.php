<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\FileReader;
use Filchos\Imago\Transformer\HtmlToDom;

class QuerySelectorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $imago = new FileReader(__DIR__ . '/files/cities.html');
        $imago = new HtmlToDom($imago);
        $this->doc = $imago->get();
    }

    public function testBasic()
    {
        $this->assertInstanceOf('DomDocument', $this->doc);
        $this->assertInstanceOf('Filchos\\Imago\\DOM\\ExtendedDOMElement', $this->doc->documentElement);

        $cities = $this->doc->querySelectorAll('.subitem:not(.inactive) li');

        $this->assertSame(4, $cities->length);
        $this->assertSame('Sikeå', $cities->item(1)->nodeValue);

        $wrapper = $this->doc->querySelector('body > div');
        $this->assertSame('container', $wrapper->getAttribute('id'));
    }

    public function testTwoStep()
    {
        $lastSubitemNode = $this->doc->querySelector('.subitem:not(.inactive):last-child');
        $city = $lastSubitemNode->querySelector('li:last-child');
        $this->assertSame('Sävar', $city->nodeValue);
    }

    /**
     * @expectedException Filchos\Imago\Exception\QuerySelectorException
     */
    public function testNotFound()
    {
        $this->doc->querySelector('h1.city');
    }
}
