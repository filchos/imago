<?php

namespace Filchos\Imago\Transformer;

use Exception as RootException;
use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Transformable;

class TwoTrialsCachedTransformer extends CachedTransformer
{

    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);
        $ttl = $this->options()->get('cache')->options()->get('ttl');
        $this->options()->force('ttl2', function ($number) use($ttl) { return is_int($number) && $number > $ttl; });
    }

    public function get()
    {
        try {
            return parent::get();
        } catch (RootException $e) {
            // some error had happened. Let’s try to get the data anyway
            // from the same cache, but with a longer time to live (ttl2)
            $options = $this->options();
            $cache   = clone $options->get('cache');
            $cache->options()->set('ttl', $this->options()->get('ttl2'));
            $key     = $options->get('key');
            return $cache->get($key);
        }
    }
}
