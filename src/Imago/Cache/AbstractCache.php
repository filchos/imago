<?php

namespace Filchos\Imago\Cache;

use Filchos\Imago\Container\AbstractContainer;
use Filchos\Imago\Container\LocalContainer;
use Filchos\Imago\Codec\PhpSerializeCodec;

abstract class AbstractCache extends AbstractContainer implements CacheInterface
{

    protected $options;

    public function __construct(array $args = [])
    {
        $this->options = new LocalContainer($args);
        $this->options
            ->setUnlessExists('codec', new PhpSerializeCodec())
            ->force('codec', function ($item) { return is_a($item, 'Filchos\\Imago\\Codec\\CodecInterface'); })
            ->force('ttl', function ($number) { return is_int($number) && $number > 0; })
        ;
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
