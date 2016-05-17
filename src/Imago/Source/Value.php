<?php

namespace Filchos\Imago\Source;

class Value extends AbstractSource
{

    public function __construct($mixed)
    {
        parent::__construct(['value' => $mixed]);
    }

    public function get()
    {
        return $this->options()->get('value');
    }
}
