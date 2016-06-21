<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\JsonException;

/**
 * transforms a json string into a php value (scalar, array, or object) by decoding the string
 */
class JsonDecoder extends AbstractTransformer
{

    /**
     * test if the input is a string
     *
     * @param mixed input
     * @return is $input a string?
     */
    protected function accept($input)
    {
        return is_string($input);
    }

    /**
     * decode the json string
     *
     *
     * @param string? the input from the inner transformable
     * @return mixed the decoded data
     * @throws Filchos\Imago\Exception\JsonException on json error
     */
    protected function transform($input)
    {
        if ($input === '') {
            throw new EmptyException;
        }
        $output = json_decode($input);

        if (json_last_error() != JSON_ERROR_NONE) {
            if (!function_exists('json_last_error_msg')) {
                require_once __DIR__ . '/../../polyfills/json_last_error_msg.php';
            }
            throw new JsonException(json_last_error_msg(), json_last_error());
        }

        return $output;
    }
}
