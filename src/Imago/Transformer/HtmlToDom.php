<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\Transformer;

use Filchos\Imago\DOM\ExtendedDOMDocument;
use Filchos\Imago\Transformable;

/**
 * transform an html string into a DomDocument
 *
 * this is an extension of the XmlToDom class. HtmlToDom can read
 * invalid html. The resulting object has two additional methods
 * defined in Imago\DOM\QuerySelectorTrait:
 * querySelector and querySelectorAll
 * These function make use of symfony/css-selector
 *
 * options:
 * - (string) encoding the string encoding (default: UTF-8)
 *
 * @see Filchos\Imago\Transformer\XmlToDom
 * @see Imago\DOM\QuerySelectorTrait
 */
class HtmlToDom extends XmlToDom
{

    /**
     * constructor
     *
     * @param Filchos\Imago\Transformable $inner the inner transformer
     * @param array $args option arguments
     */
    public function __construct(Transformable $inner, array $args = [])
    {
        parent::__construct($inner, $args);
        $this->options()->setUnlessExists('encoding', 'UTF-8');
    }

    /**
     * loads the input string into the doc with the correct encoding
     *
     * @param the xml string
     * @return the DocDocument
     * @see Filchos\Imago\Transformer\XmlToDom
     */
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
