<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Exception;

/**
 * thrown in Filchos\Imago\Source\HttpRequest when a curl error occurs, but not on timeouts
 *
 * @see CurlTimeoutException
 */
class CurlException extends Exception
{
}
