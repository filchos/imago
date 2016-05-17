<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Transformable;

abstract class AbstractTransformer extends AbstractSource
{

    protected $inner;

    public function __construct(Transformable $inner, array $options = [])
    {
        parent::__construct($options);
        $this->inner = $inner;
    }

    public function inner()
    {
        return $this->inner;
    }

    public function get()
    {
        return $this->transform($this->inner()->get());
    }

    abstract protected function transform($mixed);
}
