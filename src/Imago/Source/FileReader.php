<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Exception\NotFoundException;
use Filchos\Imago\Exception\OptionException;

class FileReader extends AbstractSource
{

    public function __construct($mixed)
    {
        if (is_string($mixed)) {
            $mixed = ['path' => $mixed];
        }
        if (!is_array($mixed)) {
            throw new OptionException('invalid constructor parameter');
        }
        parent::__construct($mixed);
        $this->options()->force('path');
    }

    public function get()
    {
        $path = $this->options()->get('path');
        if (is_readable($path)) {
            return file_get_contents($path);
        } else {
            throw new NotFoundException($path);
        }
    }
}
