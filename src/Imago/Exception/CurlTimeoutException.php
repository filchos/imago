<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in Filchos\Imago\Source\HttpRequest when a timeout related curl error occurs
 *
 * @see CurlException
 */
class CurlTimeoutException extends CurlException
{
}
