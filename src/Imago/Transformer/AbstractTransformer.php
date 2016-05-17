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

    public function getInner()
    {
        return $this->inner;
    }

    public function get()
    {
        return $this->transform($this->getInner()->get());
    }

    abstract protected function transform($mixed);
}
