<?php

/**
 * part of the library filchos/imago
 *
 * @package filchos/imago
 * @author  Olaf Schneider <mail@olafschneider.net>
 */

namespace Filchos\Imago\DOM;

use DOMXPath;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\CssSelector\CssSelectorConverter;

/**
 * adds two dom methods: querySelector and querySelectorAll to mimic the JavaScript DOM functions
 * with the same name
 */
trait QuerySelectorTrait
{

    /**
     * gets the first DOM element by a given selector or null, when no matching element was found
     *
     * @param string $selector the query selector
     * @return DOMElement (or a subclass) the first matching element or null
     */
    public function querySelector($selector)
    {
        $nodes = $this->querySelectorAll($selector);
        foreach ($nodes as $node) {
            return $node;
        }
        return null;
    }

    /**
     * returns a list of DOM elements matching the query
     *
     * @param string $selector the query selector
     * @return DOMNodeList a list of matching elements
     */
    public function querySelectorAll($selector)
    {
        $doc   = $this->getOwnerDocument();
        $xpath = new DOMXPath($doc);
        $query = (new CssSelector())->toXPath($selector);
        return $xpath->query($query, $this);
    }
}
