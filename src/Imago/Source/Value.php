<?php

namespace Filchos\Imago\Source;

class Value extends AbstractSource
{

    function __construct($mixed)
    {
        parent::__construct(['value' => $mixed]);
    }

    function get() {
        return $this->options['value'];
    }

}
