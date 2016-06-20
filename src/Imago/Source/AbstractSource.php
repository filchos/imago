<?php

namespace Filchos\Imago\Source;

use Filchos\Imago\Container\LocalSerialContainer;
use Filchos\Imago\Transformable;

/**
 * abstract class for all Filchos\Imago\Transformable objects, that don’t decorate another
 * transformer. Since these classes are independant of other Transformables, they are called sources
 * @abstract
 */
abstract class AbstractSource implements Transformable
{

    /**
     * the option container
     * @see AbstractSource->options
     * @var SerialContainerInterface
     */
    private $options;

    /**
     * the meta container
     * @see AbstractSource->meta
     * @var SerialContainerInterface
     */
    private $meta;

    /**
     * constructor
     * @param array $args optional arguments
     */
    public function __construct(array $args = [])
    {
        $this->options = new LocalSerialContainer($args);
        $this->meta    = new LocalSerialContainer([]);
    }

    /**
     * overwritten clone method to create deep copies of $options and $meta
     */
    public function __clone()
    {
        $this->options = clone $this->options;
        $this->meta    = clone $this->meta;
    }

    /**
     * get data. The data my be from different type, e.g. PHP objects, a string or a DOMDocument
     * @abstract
     * @return mixed the data of a Filchos\Imago\Transformable object
     */
    abstract public function get();

    /**
     * helper to make the object callable. Instead of $instance->get() it is possible to call
     * $instance()
     * @return mixed the data of a Filchos\Imago\Transformable object
     */
    public function __invoke()
    {
        return $this->get();
    }

    /**
     * get the option container
     * The options act as a request to an instance. They contain e.g. url-s for http requests or
     * expiration times for caching
     * @see Filchos\Imago\Container\LocalSerialContainer and Filchos\Imago\Container\LocalContainer for the container methods
     * @return SerialContainerInterface options
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * get the meta container
     * The meta values act as an additional response from an instance. They contain e.g. response
     * headers from a http request or e caught exception
     * @see Filchos\Imago\Container\LocalSerialContainer and Filchos\Imago\Container\LocalContainer for the container methods
     * @return SerialContainerInterface meta values
     */
    public function meta()
    {
        return $this->meta;
    }

    /**
     * a shortcut for chaining Transformables that resembels piping commands in the command line
     * instead of writing $imago = new OuterClass(new InnerClass); you could write
     * (new InnerClass)->to('OuterClass'). You could say, that the OuterClass decorates the
     * InnerClass.
     * @param string the full decorator class name including the namespace
     * @param array $args optional arguments for the decorator
     * @return Filchos\Imago\Transformable the decorator class, that decorated $this
     */
    public function to($decoratorClassName, array $args = [])
    {
        return new $decoratorClassName($this, $args);
    }

    /**
     * get the scent. A scent is a unique string for the class, including all decorated inner classes and all
     * options is is used by the cache class to create a unique key
     * @return string the scent
     */
    public function scent()
    {
        return get_class($this) . '(' . json_encode($this->getScentParameters(), JSON_FORCE_OBJECT) . ')';
    }

    /**
     * get all options of the current class that are relevant for building the scent.
     * This class could be overwritten either to remove parts of the options that cannot be
     * json-encoded or to add other parameters that are needed to make the return value unique for
     * this instance.
     * This method should only be called by the scent method.
     * @return array a list of parameters that are unique for this instance
     */
    protected function getScentParameters()
    {
        return $this->options->all();
    }
}
