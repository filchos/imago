<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\FormatException;

class JsonDecoder extends AbstractTransformer
{

    protected function transform($input)
    {
        $output = json_decode($input);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new FormatException('invalid json');
        }

        return $output;
    }
}
