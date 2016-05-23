<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Transformer\FileCachedTransformer;

class FileCachedTransformerTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->cachePath = __DIR__ . '/cache/';
        $cache = new FileCache($this->cachePath, 300);
        $cache->flush();
    }

    public function testWithoutCache()
    {
        $value1 = (new RandomValue())->get();
        $value2 = (new RandomValue())->get();
        $this->assertNotEquals($value1, $value2);
    }

    public function testCache()
    {
        $values = [];
        foreach ([0, 1] as $void) {
            $imago    = new RandomValue();
            $args     = ['path' => $this->cachePath];
            $imago    = new FileCachedTransformer($imago, $args);
            $values[] = $imago->get();
        }
        $this->assertEquals($values[0], $values[1]);
    }
}
