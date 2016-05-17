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
        if (!is_array($mixed) || !isset($mixed['path'])) {
            throw new OptionException('missing file option');
        }
        parent::__construct($mixed);
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
