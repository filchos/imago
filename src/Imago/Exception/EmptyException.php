<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in classes where an empty input is not appropriate, as e.g. in decoding json or getting
 * DOM from an xml string
 */
class EmptyException extends Exception
{
}
