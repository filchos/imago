<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;
    private $meta;

    public function __construct(array $options = [])
    {
        $this->options = new Container($options, $this);
        $this->meta    = new Container([],       $this);
    }

    public function __invoke()
    {
        return $this->get();
    }

    public function options()
    {
        return $this->options;
    }

    public function meta()
    {
        return $this->meta;
    }

    public function to($decoratorClassName, array $options = [])
    {
        return new $decoratorClassName($this, $options);
    }
}
