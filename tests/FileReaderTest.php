<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Source\FileReader;

class FileReaderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Filchos\Imago\Exception\OptionException
     * @expectedExceptionMessage invalid constructor parameter
     */
    public function testWrongConstructorParameterType()
    {
        $imago = new FileReader(-1);
    }

    /**
     * @expectedException Filchos\Imago\Exception\OptionException
     * @expectedExceptionMessage missing file option
     */
    public function testMissingPath()
    {
        $imago = new FileReader(['another-option' => 'a-value']);
    }

    /**
     * @expectedException Filchos\Imago\Exception\NotFoundException
     */
    public function testMissingFile()
    {
        $imago = new FileReader(['path' => __DIR__ . '/files/missing.txt']);
        $value = $imago->get();
    }

    public function testReadFile()
    {
        $imago = new FileReader(['path' => __DIR__ . '/files/city.txt']);
        $this->assertSame('Haparanda', $imago->get());
    }

    public function testOption()
    {
        $imago = new FileReader(['path' => __DIR__ . '/files/city.txt']);
        $this->assertSame(__DIR__ . '/files/city.txt', $imago->options()->get('path'));
    }

    public function testReadFileUsingConstructorShortcut()
    {
        $imago = new FileReader(__DIR__ . '/files/city.txt');
        $this->assertSame('Haparanda', $imago->get());
    }
}
