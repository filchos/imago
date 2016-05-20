<?php

namespace Filchos\Imago;

interface ContainerInterface
{

    public function all();

    public function get($name, $default = null);

    public function has($name);

    public function set($name, $value);

    public function delete($name);
}
