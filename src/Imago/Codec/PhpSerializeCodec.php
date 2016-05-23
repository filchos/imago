<?php

namespace Filchos\Imago\Codec;

class PhpSerializeCodec implements CodecInterface
{

    public function encode($rawValue)
    {
        return serialize($rawValue);
    }

    public function decode($encodedValue)
    {
        return unserialize($encodedValue);
    }
}
