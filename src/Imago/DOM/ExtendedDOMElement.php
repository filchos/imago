<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\DOM;

use DOMElement;

/**
 * implements querySelector() and querySelectorAll()
 * @see QuerySelectorTrait
 */
class ExtendedDOMElement extends DOMElement
{
    use QuerySelectorTrait;

    /**
     * return the matching DOMDocument (owner document)
     * helper function for the QuerySelectorTrait
     */
    protected function getOwnerDocument()
    {
        return $this->ownerDocument;
    }
}
