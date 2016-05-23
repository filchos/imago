<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container\LocalContainer;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;
    private $meta;

    public function __construct(array $args = [])
    {
        $this->options = new LocalContainer($args);
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
