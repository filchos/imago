<?php

namespace Filchos\Imago\Transformer;

class Identity extends AbstractTransformer
{

    protected function transform($input)
    {
        $output = $input;
        return $output;
    }
}
