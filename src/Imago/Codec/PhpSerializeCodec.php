<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Codec;

/**
 * serializes and unserializes data using the standard php serialization
 */
class PhpSerializeCodec implements CodecInterface
{

    /**
     * serializes data using serialize()
     *
     * @param mixed $rawValue the original data
     * @return string the serialized data
     */
    public function encode($rawValue)
    {
        return serialize($rawValue);
    }

    /**
     * unserializes data using unserialize()
     *
     * @param string $encodedValue the serialized data
     * @return mixed the original data
     */
    public function decode($encodedValue)
    {
        return unserialize($encodedValue);
    }
}
