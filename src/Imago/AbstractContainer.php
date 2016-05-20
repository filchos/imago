<?php

namespace Filchos\Imago;

use ArrayAccess;
use Filchos\Imago\ContainerInterface;

abstract class AbstractContainer implements ArrayAccess, ContainerInterface
{

    public function get($name, $default = null)
    {
        if ($this->has($name)) {
            return $this[$name];
        } else {
            return $default;
        }
    }

    public function has($name)
    {
        return isset($this[$name]);
    }

    public function set($name, $value)
    {
        $this[$name] = $value;
        return $this;
    }

    public function setUnlessExists($name, $value)
    {
        if (!$this->has($name)) {
            $this->set($name, $value);
        }
        return $this;
    }

    public function delete($name)
    {
        unset($this[$name]);
        return $this;
    }
}
