<?php

namespace Filchos\Imago\Codec;

interface CodecInterface
{

    public function encode($rawValue);

    public function decode($encodedValue);
}
