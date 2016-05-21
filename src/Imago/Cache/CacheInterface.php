<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\ContainerInterface;

interface CacheInterface extends ContainerInterface
{

    public function flush();
}
