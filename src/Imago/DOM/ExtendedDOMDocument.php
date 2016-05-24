<?php

namespace Filchos\Imago\DOM;

use DOMDocument;

class ExtendedDOMDocument extends DOMDocument
{
    use QuerySelectorTrait;

    protected function getOwnerDocument()
    {
        return $this;
    }
}
