<?php

namespace Filchos\Imago\Transformer;

use Exception;

class ExceptionCatcher extends AbstractTransformer
{

    public function get()
    {
        try {
            $innerData = $this->inner()->get();
        } catch (Exception $e) {
            $inputData = $this->options()->get('onError', null);
            if (is_callable($inputData)) {
                $inputData = $inputData();
            }
            $this->meta()->set('exception', $e);
        }
        return $inputData;
    }
}
