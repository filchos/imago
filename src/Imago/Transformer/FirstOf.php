<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Exception as AnyException;
use Filchos\Imago\Exception\FirstOfException;
use Filchos\Imago\Transformable;

/**
 * get the result of the first transformable (of a list of transformables) that
 * doesn’t throw an exception
 */
class FirstOf extends AbstractTransformer
{

    /**
     * @var array of Transformables
     */
    protected $innerCollection;

    /**
     * constructor
     *
     * @param Filchos\Imago\Transformable $inner the inner transformer
     */
    public function __construct(Transformable $inner)
    {
        parent::__construct($inner);
        // inner will be defined to the used inner transformable in the get method
        $this->inner = null;
        $this->innerCollection = [$inner];
    }

    /**
     * add another transformable to the list
     * @param Filchos\Imago\Transformable $inner a fallback transformable
     * @return $this for method chaining
     */
    public function otherwise(Transformable $inner)
    {
        $this->innerCollection[] = $inner;
        return $this;
    }

    /**
     * get a result of the first transformable doesn’t throw an exception
     *
     * @throws Filchos\Imago\Exception\FirstOfException when no transformable went through
     */
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
}
