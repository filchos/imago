<?php

namespace Filchos\Imago\Transformer;

use DOMDocument;
use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\DomException;

class DomToSimpleXml extends AbstractTransformer
{

    protected function accept($input)
    {
        return is_a($input, 'DomDocument');
    }

    protected function transform($input)
    {
        return simplexml_import_dom($input);
    }
}
