<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    protected $options;

    function __construct(array $options = [])
    {
        $this->options = $options;
    }

    function __invoke() {
        return $this->get();
    }

}
