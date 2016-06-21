<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\DOM;

use DOMDocument;

/**
 * implements querySelector() and querySelectorAll()
 * @see QuerySelectorTrait
 */
class ExtendedDOMDocument extends DOMDocument
{
    use QuerySelectorTrait;

    /**
     * return $this as owner document
     * helper function for the QuerySelectorTrait
     */
    protected function getOwnerDocument()
    {
        return $this;
    }
}
