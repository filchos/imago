<?php

namespace Filchos\Imago;

/**
 * basic interface for all Sources and Transformers
 */
interface Transformable
{

	/**
	 * get data. The data my be from different type, e.g. PHP objects, a string or a DOMDocument
	 *
	 * @return mixed the data of a Filchos\Imago\Transformable object
	 */
    public function get();
}
