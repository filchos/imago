<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\AbstractContainer;

class FileCache extends AbstractContainer
{

    protected $path;
    protected $ttl;
    protected $codec;

    // TODO: better injection

    public function __construct($path, $ttl, CodecInterface $codec = null)
    {
        if (is_null($codec)) {
            $codec = new PhpSerializeCodec;
        }

        $this->path  = rtrim($path, '/') . '/';
        $this->ttl   = $ttl;
        $this->codec = $codec;
    }

    public function offsetExists($key)
    {
        $path = $this->getPath($key);
        return file_exists($path) && filemtime($path) + $this->ttl >= time();
    }

    public function offsetSet($key, $value)
    {
        $path = $this->getPath($key);
        file_put_contents($path, $this->codec->encode($value));
    }

    public function offsetGet($key)
    {
        $path = $this->getPath($key);
        return $this->codec->decode(file_get_contents($path));
    }

    public function offsetUnset($key)
    {
        $path = $this->getPath($key);
        unlink($path);
    }

    public function flush()
    {
        $pattern = $this->path . '*.cache';
        $paths = glob($pattern);
        foreach($paths as $path) {
            unlink($path);
        }
    }

    protected function getPath($key)
    {
        return $this->path . md5($key) . '.cache';
    }
}
