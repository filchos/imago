<?php

namespace Filchos\Imago\Container;

use ArrayAccess;
use Filchos\Imago\Exception\InvalidKeyException;

abstract class AbstractContainer implements ArrayAccess, ContainerInterface
{

    public function get($name, $default = null)
    {
        if (isset($this[$name])) {
            return $this[$name];
        } elseif (func_num_args() > 1) {
            return $default;
        } else {
            throw new InvalidKeyException;
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
