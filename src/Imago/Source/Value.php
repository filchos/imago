<?php

namespace Filchos\Imago\Source;

/**
 * Kind of a dummy source. If will take any value in the constructor and return
 * it in the get method. Consider it as casting something to a Filchos\Imago\Transformable
 */
class Value extends AbstractSource
{

	/**
	 * constructor
	 * takes any value
     *
	 * @param mixed anything
	 */
    public function __construct($mixed)
    {
        parent::__construct(['value' => $mixed]);
    }

    /**
     * returns the value used in the constructor
     *
     * @return mixed the value
     */
    public function get()
    {
        return $this->options()->get('value');
    }
}
