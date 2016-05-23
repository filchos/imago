<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\AcceptException;
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
        $input = $this->inner()->get();
        if (!$this->accept($input)) {
            throw new AcceptException;
        }
        return $this->transform($input);
    }

    public function scent()
    {
        return $this->inner()->scent() . "\n" . parent::scent();
    }

    protected function accept($input)
    {
        return true;
    }

    abstract protected function transform($mixed);

}
