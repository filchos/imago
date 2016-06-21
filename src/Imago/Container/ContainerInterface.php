<?php

namespace Filchos\Imago\Container;

use ArrayAccess;

interface ContainerInterface extends ArrayAccess
{

    public function get($key, $default = null);

    public function has($key);

    public function set($key, $value);

    public function delete($key);
}
