<?php

namespace Filchos\Imago\Container;

interface ContainerInterface
{

    public function get($name, $default = null);

    public function has($name);

    public function set($name, $value);

    public function delete($name);
}
