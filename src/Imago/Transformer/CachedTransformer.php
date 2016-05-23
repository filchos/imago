<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Transformable;

class CachedTransformer extends AbstractTransformer
{

    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);

        $this->options()
            ->setUnlessExists('key', md5($this->inner()->scent()))
            ->force('cache', function ($item) {return is_a($item, 'Filchos\\Imago\\Cache\\CacheInterface'); })
            ->force('key', function ($item) { return is_string($item) && strlen($item) <= 32; })
        ;
    }

    public function get()
    {
        $options = $this->options();
        $cache   = $options->get('cache');
        $key     = $options->get('key');

        if ($cache->has($key)) {
            $data = $cache->get($key);
        } else {
            $data = $this->inner()->get();
            $cache->set($key, $data);
        }
        return $data;
    }
}
