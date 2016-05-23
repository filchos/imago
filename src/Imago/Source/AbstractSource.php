<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container\LocalContainer;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;
    private $meta;

    public function __construct(array $options = [])
    {
        $this->options = new LocalContainer($options);
        $this->meta    = new LocalContainer([]);
    }

    abstract public function get();

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

    public function scent()
    {
        return get_class($this) . '(' . json_encode($this->options->all(), JSON_FORCE_OBJECT) . ')';
    }
}
