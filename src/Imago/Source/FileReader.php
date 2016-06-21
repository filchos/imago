<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Exception\NotFoundException;
use Filchos\Imago\Exception\OptionException;

/**
 * reads and returns the content of a local file
 *
 * options:
 * - (string) path the file path (mandatory)
 */
class FileReader extends AbstractSource
{

    /**
     * constructor
     *
     * @param (string|array) option arguments. If this is a string it is used as the path option
     * @throws Filchos\Imago\Exception\OptionException on invalid argument
     */
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

    /**
     * get the content of a file
     *
     * @return string the file content
     * @throws Filchos\Imago\Exception\NotFoundException on file not readable
     */
    public function get()
    {
        $path = $this->options()->get('path');
        if (is_readable($path) && !is_dir($path)) {
            return file_get_contents($path);
        } else {
            throw new NotFoundException($path);
        }
    }
}
