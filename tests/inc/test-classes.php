<?php

use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Transformer\AbstractTransformer;

class ExceptionThrower extends AbstractSource
{

    public function get()
    {
        throw new ExceptionThrowException;
    }
}

class ExceptionThrowException extends Exception
{
}

class JokkmokkSource extends AbstractSource
{

    public function get()
    {
        return 'Jokkmokk';
    }
}

class MetaSource extends AbstractSource
{

    public function get()
    {
        $this->meta()->set('inited', true);
        return null;
    }
}

class OptionSource extends AbstractSource
{

    public function get()
    {
        return null;
    }
}

class OwnScent extends AbstractSource
{

    public function get()
    {
        return null;
    }

    protected function getScentParameters()
    {
        return ['ownScent' => true];
    }
}

class Repeater extends AbstractTransformer
{

    public function transform($string)
    {
        $multiplier = (int) $this->options()->get('repeat', 2);
        return str_repeat($string, $multiplier);
    }
}
