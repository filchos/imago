<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Exception\NotFoundException;
use Filchos\Imago\Exception\OptionException;

/**
 * reads and returns the content of a local file
 */
class FileReader extends AbstractSource
{

    /**
     * constructor
     * @param (string|array) the option arguments. If this is a string it is used as the path option
     * Possible option arguments
     * - (string) `path` the file path (mandatory)
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
     * gets the content of a file
     * @throws Filchos\Imago\Exception\NotFoundException
     * @return string the file content
     */
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
