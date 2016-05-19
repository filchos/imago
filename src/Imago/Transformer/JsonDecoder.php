<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\JsonException;

if (!function_exists('json_last_error_msg')) {
    require_once __DIR__ . '/../../polyfills/json_last_error_msg.php';
}

class JsonDecoder extends AbstractTransformer
{

    protected function transform($input)
    {
        if ($input === '') {
            throw new EmptyException;
        }
        $output = json_decode($input);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonException(json_last_error_msg(), json_last_error());
        }

        return $output;
    }

}
