<?php

namespace Filchos\Imago\Cache;

class FileCache extends AbstractCache
{

    public function __construct(array $args = [])
    {
        parent::__construct($args);
        $this->options->force('path');
        $this->options['path'] = rtrim($this->options['path'], '/') . '/';
    }

    public function offsetExists($key)
    {
        $path = $this->getPath($key);
        $ttl  = $this->options->get('ttl');
        return file_exists($path) && filemtime($path) + $ttl >= time();
    }

    public function offsetSet($key, $value)
    {
        $path  = $this->getPath($key);
        $codec = $this->getCodec();
        file_put_contents($path, $codec->encode($value));
    }

    public function offsetGet($key)
    {
        $path  = $this->getPath($key);
        $codec = $this->getCodec();
        return $codec->decode(file_get_contents($path));
    }

    public function offsetUnset($key)
    {
        $path = $this->getPath($key);
        unlink($path);
    }

    public function flush()
    {
        $pattern = $this->getPath('*', false);
        $paths = glob($pattern);
        foreach ($paths as $path) {
            unlink($path);
        }
    }

    protected function getCodec()
    {
        return $this->options()->get('codec');
    }

    protected function getPath($key, $hash = true)
    {
        $name = ($hash ? md5($key) : $key) . '.cache';
        return $this->options()->get('path') . $name;
    }
}
