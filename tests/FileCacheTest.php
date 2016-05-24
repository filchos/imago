<?php

require_once __DIR__ . '/../vendor/autoload.php';

class FileCacheTest extends PHPUnit_Framework_TestCase
{

    use FinallyEmptyCacheTrait;

    const A_WHOLE_HOUR = 3600;

    public function setUp()
    {
        $this->cache = new DateableFileCache([
            'path' => $this->getCachePath(),
            'ttl'  => 60
        ]);
        $this->cache->flush();
    }

    /**
     * checks if the cache folder is writable from the current process
     */
    public function testFolderPermissions()
    {
        $this->assertTrue(is_writable($this->getCachePath()));
    }

    public function testGet()
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
        $this->assertSame('Vindeln', $this->cache->get('city'));
        $this->assertSame('Västerbotten', $this->cache->get('region'));
        $this->cache->flush();
        $this->assertFalse($this->cache->has('city'));
        $this->assertFalse($this->cache->has('region'));
    }

    /**
     * @expectedException Filchos\Imago\Exception\MissingKeyException
     */
    public function testExpired()
    {
        $this->cache->set('city', 'Murjek');
        $this->cache->redate('city', -self::A_WHOLE_HOUR);
        $this->cache->get('city');
    }

    /**
     * @expectedException Filchos\Imago\Exception\MissingKeyException
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

    public function testIndependentOptionContainerOnClone()
    {
        $newCache = clone $this->cache;
        $this->assertSame(60, $newCache->options()->get('ttl'));
        $newCache->options()->set('ttl', 3600);
        $this->assertSame(3600, $newCache->options()->get('ttl'));
        $this->assertSame(60, $this->cache->options()->get('ttl'));
    }


    protected function getCachePath()
    {
        return __DIR__ . '/cache/';
    }
}
