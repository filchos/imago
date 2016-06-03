<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container\LocalSerialContainer;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;
    private $meta;

    public function __construct(array $args = [])
    {
        $this->options = new LocalSerialContainer($args);
        $this->meta    = new LocalSerialContainer([]);
    }

    public function __clone()
    {
        $this->options = clone $this->options;
        $this->meta    = clone $this->meta;
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

    public function to($decoratorClassName, array $args = [])
    {
        return new $decoratorClassName($this, $args);
    }

    public function scent()
    {
        return get_class($this) . '(' . json_encode($this->getScentParameters(), JSON_FORCE_OBJECT) . ')';
    }

    protected function getScentParameters()
    {
        return $this->options->all();
    }
}
