<?php

use Filchos\Imago\Cache\FileCache;
use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Transformer\AbstractTransformer;

class DateableFileCache extends FileCache
{
    public function redate($key, $offset)
    {
        $path = $this->getPath($key);
        touch($path, filemtime($path) + $offset);
        clearstatcache();
   }
}

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

class OnceSource extends AbstractSource
{

    static $hit = false;

    public function get()
    {
        if (self::$hit) {
            throw new OnceSourceException;
        } else {
            self::$hit = true;
            return 1;
        }
    }

    public function reset()
    {
        self::$hit = false;
    }
}

class OnceSourceException extends Exception
{
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

class RandomValue extends AbstractSource
{

    public function get()
    {
        return mt_rand();
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
