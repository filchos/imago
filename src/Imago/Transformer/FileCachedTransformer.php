<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Cache\PhpSerializeCodec;
use Filchos\Imago\Transformable;

class FileCachedTransformer extends AbstractTransformer
{

    public function __construct(Transformable $inner, array $args = [])
    {

        parent::__construct($inner, $args);

        $options = $this->options();
        $options
            ->setUnlessExists('codec', new PhpSerializeCodec)
            ->setUnlessExists('key', md5($this->inner()->scent()))
            #->force('path')
            ->setUnlessExists('ttl', 300)
        ;

        $cache = new FileCache($options->get('path'), $options->get('ttl'), $options->get('codec'));
        $options->set('cache', $cache);
    }

    public function get()
    {
        $options = $this->options();
        $cache   = $options->get('cache');
        $key     = $options->get('key');

        if ($cache->has($key)) {
            $data = $cache->get($key);
        } else
            $data = $this->inner()->get();
            $cache->set($key, $data);
        }
        return $data;
    }

    public function transform($input)
    {
        return $input;
    }
}
