<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Codec;

/**
 * encoded to and decodes from json
 */
class JsonCodec implements CodecInterface
{

    /**
     * encodes data to json
     *
     * @param mixed $rawValue the original data
     * @return string the serialized data
     */
    public function encode($rawValue)
    {
        return json_encode($rawValue);
    }

    /**
     * decodes data from json
     *
     * @param string $encodedValue the serialized data
     * @return mixed the original data
     */
    public function decode($encodedValue)
    {
        return json_decode($encodedValue);
    }
}
