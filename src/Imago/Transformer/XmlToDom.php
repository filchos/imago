<?php

namespace Filchos\Imago\Transformer;

use DOMDocument;
use Filchos\Imago\Exception\EmptyException;
use Filchos\Imago\Exception\DomException;

class XmlToDom extends AbstractTransformer
{

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

    protected function loadIntoDoc($input)
    {
        $doc = new DOMDocument();
        $doc->loadXML($input);
        return $doc;
    }
}
