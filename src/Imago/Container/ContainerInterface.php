<?php

namespace Filchos\Imago\Container;

interface ContainerInterface
{

    public function get($key, $default = null);

    public function has($key);

    public function set($key, $value);

    public function delete($key);
}
