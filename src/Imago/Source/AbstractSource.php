<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;

    public function __construct(array $options = [])
    {
        $this->options = new Container($options);
    }

    public function __invoke()
    {
        return $this->get();
    }

    public function options() {
        return $this->options;
    }

    public function to($decoratorClassName, array $options = [])
    {
        return new $decoratorClassName($this, $options);
    }
}
