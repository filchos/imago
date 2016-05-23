<?php

namespace Filchos\Imago\Transformer;

use Exception as RootException;

class ExceptionCatcher extends AbstractTransformer
{

    public function get()
    {
        try {
            $innerData = $this->inner()->get();
        } catch (RootException $e) {
            $inputData = $this->options()->get('onError', null);
            if (is_callable($inputData)) {
                $inputData = $inputData();
            }
            $this->meta()->set('exception', $e);
        }
        return $inputData;
    }
}
