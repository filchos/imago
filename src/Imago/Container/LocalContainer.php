<?php

namespace Filchos\Imago;

class Container extends AbstractContainer
{

    protected $entries;

    public function __construct(array $entries = [])
    {
        $this->entries = $entries;
    }

    public function all()
    {
        return $this->entries;
    }

    public function offsetExists($key)
    {
        return isset($this->entries[$key]);
    }

    public function offsetSet($key, $value)
    {
        $this->entries[$key] = $value;
    }

    public function offsetGet($key)
    {
        return $this->entries[$key];
    }

    public function offsetUnset($key)
    {
        unset($this->entries[$key]);
    }
}
