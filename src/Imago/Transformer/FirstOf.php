<?php

namespace Filchos\Imago\Transformer;

use Exception as AnyException;
use Filchos\Imago\Exception\FirstOfException;
use Filchos\Imago\Exception\NotTransformableException;
use Filchos\Imago\Transformable;

class FirstOf extends AbstractTransformer
{

    protected $innerCollection;

    protected $innerData;

    public function __construct(Transformable $inner)
    {
        parent::__construct($inner);
        // inner will be defined to the used inner transformable in the get method
        $this->inner = null;
        $this->innerCollection = [$inner];
    }

    public function otherwise(Transformable $inner)
    {
        $this->innerCollection[] = $inner;
        return $this; // chainable
    }

    public function get()
    {
        foreach ($this->innerCollection as $inner) {
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
