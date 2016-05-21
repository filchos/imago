<?php

namespace Filchos\Imago\Container;

use ArrayAccess;
use Filchos\Imago\Exception\InvalidKeyException;

abstract class AbstractContainer implements ArrayAccess, ContainerInterface
{

    public function get($key, $default = null)
    {
        if (isset($this[$key])) {
            return $this[$key];
        } elseif (func_num_args() > 1) {
            return $default;
        } else {
            throw new InvalidKeyException;
        }
    }

    public function has($key)
    {
        return isset($this[$key]);
    }

    public function set($key, $value)
    {
        $this[$key] = $value;
        return $this;
    }

    public function setUnlessExists($key, $value)
    {
        if (!$this->has($key)) {
            $this->set($key, $value);
        }
        return $this;
    }

    public function delete($key)
    {
        unset($this[$key]);
        return $this;
    }
}
