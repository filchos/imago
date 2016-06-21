<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Codec;

/**
 * interface for serializing date into a string and unserialize it from a string
 * used in the Cache component
 */
interface CodecInterface
{

    /**
     * take mixed data and serialize / encode it into a string
     *
     * @param mixed $rawValue the original data
     * @return string the serialized data
     */
    public function encode($rawValue);

    /**
     * take a string and unserializes / decode it to the original data
     *
     * @param string $encodedValue the serialized data
     * @return mixed the original data
     */
    public function decode($encodedValue);
}
