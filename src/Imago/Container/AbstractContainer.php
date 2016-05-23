<?php

namespace Filchos\Imago\Container;

use ArrayAccess;
use Filchos\Imago\Exception\InvalidKeyException;
use Filchos\Imago\Exception\MissingKeyException;

abstract class AbstractContainer implements ArrayAccess, ContainerInterface
{

    public function get($key, $default = null)
    {
        if (isset($this[$key])) {
            return $this[$key];
        } elseif (func_num_args() > 1) {
            return $default;
        } else {
            throw new MissingKeyException('Missing key ' . $key);
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

    public function force($key, $validator = null)
    {
        if ($this->has($key)) {
            if ($validator) {
                $value = $this->get($key);
                if (is_callable($validator)) {
                    $valid = $validator($value);
                } else {
                    $valid = preg_match($validator, $value);
                }
                if (!$valid) {
                    throw new InvalidKeyException('Invalid key ' . $key);
                }
            }
        } else {
            throw new MissingKeyException('Missing key ' . $key);
        }
        return $this;
    }
}
