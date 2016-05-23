<?php

namespace Filchos\Imago\Cache;

class JsonCodec implements CodecInterface
{

    public function encode($rawValue)
    {
        return json_encode($rawValue);
    }

    public function decode($encodedValue)
    {
        return json_decode($encodedValue);
    }
}
