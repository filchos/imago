<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\AbstractContainer;
use Filchos\Imago\Container\LocalContainer;

abstract class AbstractCache extends AbstractContainer implements CacheInterface
{

    protected $options;

    public function __construct(array $options = [])
    {
        $this->options = new LocalContainer($options);
    }

    public function options()
    {
        return $this->options;
    }
}
