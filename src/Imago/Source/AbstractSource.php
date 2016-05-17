<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function __invoke()
    {
        return $this->get();
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($name, $default = null)
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        } else {
            return $default;
        }
    }

    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function deleteOption($name)
    {
        unset($this->options[$name]);
    }
}
