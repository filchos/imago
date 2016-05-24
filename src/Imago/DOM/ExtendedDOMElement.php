<?php

namespace Filchos\Imago\DOM;

use DOMElement;

class ExtendedDOMElement extends DOMElement
{
    use QuerySelectorTrait;

    protected function getOwnerDocument()
    {
        return $this->ownerDocument;
    }
}
