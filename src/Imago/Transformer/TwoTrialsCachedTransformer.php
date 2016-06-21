<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Exception as RootException;
use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Transformable;

/**
 * an extended cache transformer that reads an expired cache, when the inner transformable throws an exception
 *
 * sometimes you want to use a cached entry as a fallback when the original source is not available,
 * even if the cached entry is expired.
 *
 * options
 * @see Filchos\Imago\Transformer\CachedTransformer
 * - (int) ttl2 time to live in seconds for the fallback cache timeout (mandatory)
 */
class TwoTrialsCachedTransformer extends CachedTransformer
{

    /**
     * constructor
     *
     * @param Filchos\Imago\Transformable $inner the inner transformer
     * @param array $args option arguments
     */
    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);
        $ttl = $this->options()->get('cache')->options()->get('ttl');
        $this->options()->force('ttl2', function ($number) use ($ttl) { return is_int($number) && $number > $ttl; });
    }

    /**
     * get the value as defined in the parent class Filchos\Imago\Transformer\CachedTransformer
     * if an exception is thrown use the same cache with a longer ttl
     *
     * @return mixed the data
     *
     * @todo document the behaviour if cache is outdated even for ttl2
     */
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
