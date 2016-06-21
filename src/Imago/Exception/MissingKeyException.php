<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in the force method of containers when an entry for a key is missing
 *
 * @see Filchos\Imago\Container\AbstractContainer::force()
 */
class MissingKeyException extends Exception
{
}
