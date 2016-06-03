<?php

namespace Filchos\Imago\Container;

interface SerialContainerInterface extends ContainerInterface
{

    public function next();

    public function getOwn($key, $default = null);

    public function hasOwn($key);
}
