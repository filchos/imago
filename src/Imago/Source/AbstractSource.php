<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\OptionTrait;
use Filchos\Imago\Transformable;

abstract class AbstractSource implements Transformable
{

    use OptionTrait;

    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    public function __invoke()
    {
        return $this->get();
    }
}
