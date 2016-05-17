<?php

namespace Filchos\Imago;

class Container
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

    public function get($name, $default = null)
    {
        if ($this->has($name)) {
            return $this->entries[$name];
        } else {
            return $default;
        }
    }

    public function has($name)
    {
        return isset($this->entries[$name]);
    }

    public function set($name, $value)
    {
        $this->entries[$name] = $value;
    }

    public function delete($name)
    {
        unset($this->entries[$name]);
    }
}
