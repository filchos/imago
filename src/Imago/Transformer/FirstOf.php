<?php

namespace Filchos\Imago\Transformer;

use Exception as AnyException;
use Filchos\Imago\Exception\NotTransformableException;
use Filchos\Imago\Exception\FirstOfException;

class FirstOf extends AbstractTransformer
{

    protected $innerCollection;

    protected $innerData;

    public function __construct($innerCollection = [])
    {
        $this->innerCollection = $innerCollection;
    }

    public function get()
    {
        foreach ($this->innerCollection as $inner) {
            if (!is_a($inner, 'Filchos\\Imago\\Transformable')) {
                throw new NotTransformableException;
            }
            try {
                $innerData = $inner->get();
                $this->inner = $inner;
                return $innerData;
            } catch (AnyException $e) {
                // found an exception: continue the loop
            }
        }
        throw new FirstOfException;
    }

    /**
     * not used, this just fulfils the contract
     */
    protected function transform($input)
    {
        return null;
    }
}
