<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in the force method of containers when the value exists but is invalid
 *
 * @see Filchos\Imago\Container\AbstractContainer::force()
 */
class InvalidValueException extends KeyException
{
}
