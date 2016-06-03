<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\AcceptException;
use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Transformable;

abstract class AbstractTransformer extends AbstractSource
{

    protected $inner;

    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($args);
        $this->inner = $inner;
        $this->options()->setNext($inner->options());
        $this->meta()->setNext($inner->meta());
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

    protected function transform($input)
    {
        $output = $input;
        return $output;
    }
}
