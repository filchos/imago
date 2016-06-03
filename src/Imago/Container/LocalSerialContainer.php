<?php

namespace Filchos\Imago\Container;

class LocalSerialContainer extends LocalContainer implements SerialContainerInterface
{

    protected $next;

    public function setNext(SerialContainerInterface $next)
    {
        $this->next = $next;
    }

    public function next()
    {
        return ($this->next) ? $this->next : null;
    }

    public function getOwn($key, $default = null)
    {
        if (func_num_args() > 1) {
            return parent::get($key, $default);
        } else {
            return parent::get($key);
        }
    }

    public function get($key, $default = null)
    {
        if (!$this->hasOwn($key)) {
            $next = $this->next();
            if ($next) {
                if (func_num_args() > 1) {
                    return $next->get($key, $default);
                } else {
                    return $next->get($key);
                }
            }
        }
        if (func_num_args() > 1) {
            return $this->getOwn($key, $default);
        } else {
            return $this->getOwn($key);
        }
    }

    public function hasOwn($key)
    {
        return parent::has($key);
    }

    public function has($key)
    {
        if (!$this->hasOwn($key)) {
            $next = $this->next();
            if ($next) {
                return $next->has($key);
            } else {
                return false;
            }
        }
        return $this->hasOwn($key);
    }
}
