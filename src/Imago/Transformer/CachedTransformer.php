<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Transformable;

/**
 * take data from cache instead from inner transformable when the cache exists and is valid
 *
 * options:
 * - (string) key    the cache key (default: the scent of the inner transformable)
 * - (string) cache  the cache object (mandatory)
 *
 * meta values:
 * - (bool)   cached comes the result from the cache?
 */
class CachedTransformer extends AbstractTransformer
{

    /**
     * constructor
     *
     * @param Filchos\Imago\Transformable $inner the inner transformer
     * @param array $args option arguments
     * @throws Filchos\Imago\Exception\OptionException on invalid argument
     */
    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);

        $this->options()
            ->setUnlessExists('key', md5($this->inner()->scent()))
            ->force('cache', function ($item) {return is_a($item, 'Filchos\\Imago\\Cache\\CacheInterface'); })
            ->force('key', function ($item) { return is_string($item) && strlen($item) <= 32; })
        ;
    }

    /**
     * get either a cached version of the data or get data from the inner transformable
     *
     * @return mixed the data
     */
    public function get()
    {
        $options = $this->options();
        $cache   = $options->get('cache');
        $key     = $options->get('key');

        $cached  = $cache->has($key);
        $this->meta()->set('cached', $cached);

        if ($cached) {
            $data = $cache->get($key);
        } else {
            $data = $this->inner()->get();
            $cache->set($key, $data);
        }
        return $data;
    }
}
