<?php

namespace Filchos\Imago\Transformer;

use Exception as RootException;

/**
 * catch exceptions coming from inner transformables
 *
 * options:
 * - (callable|mixed) onError the replacement in case of an exception (default: null)
 */
class ExceptionCatcher extends AbstractTransformer
{

    /**
     * get either the result of the inner transformable when no exception is thrown
     * otherwise return a replacement defined in the option onError
     * - if onError is callable, the result of that callable is returned
     * - if onError is not defined, null is returned
     * - otherwise the value of the onError option is returned
     */
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
