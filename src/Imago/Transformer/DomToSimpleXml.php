<?php

namespace Filchos\Imago\Transformer;

use DOMDocument;
use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\DomException;

/**
 * transform a DomDocument to simple xml
 */
class DomToSimpleXml extends AbstractTransformer
{

    /**
     * test if the input is a dom document
     *
     * @param mixed input
     * @return is $input a DomDocument?
     */
    protected function accept($input)
    {
        return is_a($input, 'DomDocument');
    }

    /**
     * transform DomDocument to simple xml
     *
     * @param DomDocument? the input from the inner transformable
     * @return SimpleXMLElement simple xml
     */
    protected function transform($input)
    {
        return simplexml_import_dom($input);
    }
}
