<?php

namespace Filchos\Imago\DOM;

use DOMXPath;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Filchos\Imago\Exception\QuerySelectorException;

trait QuerySelectorTrait
{
    public function querySelector($selector)
    {
        $nodes = $this->querySelectorAll($selector);
        foreach ($nodes as $node) {
            return $node;
        }
        throw new QuerySelectorException('Empty node set for ' . $selector);
    }

    public function querySelectorAll($selector)
    {
        $doc   = $this->getOwnerDocument();
        $xpath = new DOMXPath($doc);
        $query = (new CssSelectorConverter())->toXPath($selector);
        return $xpath->query($query, $this);
    }
}
