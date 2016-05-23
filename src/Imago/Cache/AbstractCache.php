<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\AbstractContainer;
use Filchos\Imago\Container\LocalContainer;

abstract class AbstractCache extends AbstractContainer implements CacheInterface
{

    protected $options;

    public function __construct(array $args = [])
    {
        $this->options = new LocalContainer($args);
    }

    public function __clone()
    {
        $this->options = clone $this->options;
    }

    public function options()
    {
        return $this->options;
    }
}
