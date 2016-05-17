<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    protected $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function __invoke()
    {
        return $this->get();
    }
}
