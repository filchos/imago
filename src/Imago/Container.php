<?php

namespace Filchos\Imago;

class Container extends AbstractContainer
{

    protected $owner;
    protected $entries;

    public function __construct(array $entries = [], Transformable $owner = null)
    {
        $this->owner   = $owner;
        $this->entries = $entries;
    }

    public function owner()
    {
        return $this->owner;
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
