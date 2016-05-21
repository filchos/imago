<?php

namespace Filchos\Imago\Cache;

interface CodecInterface
{

    public function encode($rawValue);

    public function decode($encodedValue);
}
