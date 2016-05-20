<?php

namespace Filchos\Imago\Transformer;

use DOMDocument;
use Filchos\Imago\Transformable;

class HtmlToDom extends XmlToDom
{

    public function __construct(Transformable $inner, array $options = [])
    {
        parent::__construct($inner, $options);
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

        $doc = new DOMDocument;
        $doc->encoding = 'UTF-8';
        $doc->loadHTML($input);

        return $doc;
    }
}
