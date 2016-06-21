<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Filchos\Imago\Exception\AcceptException;
use Filchos\Imago\Source\AbstractSource;
use Filchos\Imago\Transformable;

/**
 * abstract class for all Filchos\Imago\Transformable objects, that decorate another transformable.
 * Since these classes transform content they are called transformers
 * From a design pattern’s perspective a transformer is a decorator, delegating some of its methods
 * to the inner transformable.
 *
 * @abstract
 */
abstract class AbstractTransformer extends AbstractSource
{

    /**
     * @var Filchos\Imago\Transformable the inner transformable
     */
    protected $inner;

    /**
     * constructor
     *
     * @param Filchos\Imago\Transformable $inner the inner transformer
     * @param array $args optional option arguments
     */
    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($args);
        $this->inner = $inner;
        $this->options()->setNext($inner->options());
        $this->meta()->setNext($inner->meta());
    }

    /**
     * get the inner transformer
     *
     * @return Filchos\Imago\Transformable the inner transformer
     */
    public function inner()
    {
        return $this->inner;
    }

    /**
     * get data from the innter container, transform it and return the result.
     * this method should be overwritten for all logic that is done before accessing the inner
     * Transformable
     *
     * @return mixed the data of a Filchos\Imago\Transformable object
     * @throws Filchos\Imago\Exception\AcceptException on invalid input coming from the inner transformable
     */
    public function get()
    {
        $input = $this->inner()->get();
        if (!$this->accept($input)) {
            throw new AcceptException;
        }
        return $this->transform($input);
    }

    /**
     * get the scent
     * @return string the scent
     * @see Filchos\Imago\Source\AbstractSource::scent
     */
    public function scent()
    {
        return $this->inner()->scent() . "\n" . parent::scent();
    }

    /**
     * validate the result from the inner container
     *
     * this method should be used to check, if the type of the result from the inner container
     * matches the needs of the current class.
     *
     * @see Filchos\Imago\Transformer\DomToSimpleXml for a simple example
     * @param mixed the result of the inner transformable
     * @return bool is the result of the inner container accepted?
     */
    protected function accept($input)
    {
        return true;
    }

    /**
     * transforms the result coming from the inner container into something different
     * e.g. decode a json string, transform an xml string into a DomDocument and so on.
     *
     * this method should be overwritten for all logic that is done after having accessed the inner
     * Transformable
     *
     * @param mixed input from the inner Transformable
     * @return mixed transformed output
     */
    protected function transform($input)
    {
        $output = $input;
        return $output;
    }
}
