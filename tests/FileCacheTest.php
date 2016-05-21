<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Filchos\Imago\Cache\FileCache;

class FileCacheTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->cache = $this->getOneMinuteFileCache();
        $this->cache->flush();
    }

    /**
     * checks if the cache folder is writable from the current process
     */
    public function testFolderPermissions()
    {
        $this->assertTrue(is_writable($this->getCachePath()));
    }

    public function testRandom()
    {
        $this->cache->set('city', 'Vännäs');
        $this->assertTrue($this->cache->has('city'));
        $this->assertSame('Vännäs', $this->cache->get('city'));
        $this->cache->setUnlessExists('city', 'Vindeln'); //should not overwrite the first
        $this->assertSame('Vännäs', $this->cache->get('city'));
    }

    public function testRemove()
    {
        $this->cache->set('city', 'Vindeln');
        $this->assertTrue($this->cache->has('city'));
        $this->cache->delete('city');
        $this->assertFalse($this->cache->has('city'));
    }

    public function testAll()
    {
        $this->cache->set('city', 'Vindeln');
        $this->cache->set('region', 'Västerbotten');
        $this->cache->flush();
        $this->assertFalse($this->cache->has('city'));
        $this->assertFalse($this->cache->has('region'));
    }

    /**
     * @expectedException Filchos\Imago\Exception\InvalidKeyException
     */
    public function testReadInvalid()
    {
        $valid = $this->cache->get('landscape');
    }

    public function testReadInvalidWithDefault()
    {
        $value = $this->cache->get('landscape', 'Lapland');
        $this->assertSame('Lapland', $value);
    }

    protected function getCachePath()
    {
        return __DIR__ . '/cache/';
    }

    protected function getOneMinuteFileCache()
    {
        return new FileCache($this->getCachePath(), 60);
    }
}
