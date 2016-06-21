<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in AbstractTransfomer::get() when the accept method returns false and so rejects the
 * result of an inner transformable
 */
class AcceptException extends Exception
{
}
