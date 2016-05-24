<?php

namespace Filchos\Imago\Transformer;

use Filchos\Imago\DOM\ExtendedDOMDocument;
use Filchos\Imago\Transformable;

class HtmlToDom extends XmlToDom
{

    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);
        $this->options()->setUnlessExists('encoding', 'UTF-8');
    }

    protected function loadIntoDoc($input)
    {
        $encoding = $this->options()->get('encoding');
        if ($encoding && strtoupper($encoding) != 'UTF-8') {
            $input = iconv($encoding, 'UTF-8', $input);
        }

        if ($encoding) {
            $input = '<?xml version="1.0" encoding="UTF-8"?' . '>' . $input;
        }

        $doc = new ExtendedDOMDocument;
        $doc->encoding = 'UTF-8';
        $doc->loadHTML($input);
        $doc->registerNodeClass('DOMElement', 'Filchos\\Imago\\DOM\\ExtendedDOMElement');

        return $doc;
    }
}
