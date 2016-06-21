<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use DOMDocument;
use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\DomException;

/**
 * transform an xml string into a DomDocument
 */
class XmlToDom extends AbstractTransformer
{

    /**
     * test if the input is a string
     *
     * @param mixed input
     * @return is $input a string?
     */
    protected function accept($input)
    {
        return is_string($input);
    }

    /**
     * transform into a DomDocument
     *
     * @param string? the input from the inner transformable
     * @return DomDocument the dom document
     * @throws Filchos\Imago\Exception\DomException on libxml error
     */
    protected function transform($input)
    {
        if (is_null($input) || $input === '') {
            throw new EmptyException;
        }

        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $doc = $this->loadIntoDoc($input);
        foreach (libxml_get_errors() as $error) {
            if ($error->level != LIBXML_ERR_WARNING) {
                throw new DomException($error->message, $error->code);
            }
        }
        libxml_clear_errors();
        return $doc;
    }

    /**
     * loads the input string into the doc
     *
     * @param the xml string
     * @return the DocDocument
     * @see Filchos\Imago\Transformer\HtmlToDom
     */
    protected function loadIntoDoc($input)
    {
        $doc = new DOMDocument();
        $doc->loadXML($input);
        return $doc;
    }
}
