<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\ContainerInterface;

/**
 * simple cache container interface
 * @see Filchos\Imago\Container\ContainerInterface
 */
interface CacheInterface extends ContainerInterface
{

    /**
     * remove all (known) cache files
     */
    public function flush();
}
