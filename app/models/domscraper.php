<?php
namespace App\Models;

use DomDocument;
use DOMXPath;

/**
* scraper class using DOMXPath
*/
class DOMScraper
{
    private $DOMXPath;

    /*
    *  creates DOMXPath object from $html
    *  http://php.net/manual/en/class.domxpath.php
    */
    public function __construct($html)
    {
        $dom = new DomDocument();
        libxml_use_internal_errors(true); //
        @$dom->loadHTML($html);

        $this->DOMXPath = new DOMXPath($dom);
    }

    /*
    * Returns array of strings (textContent property) from DOMElement object
    *
    * http://php.net/manual/en/class.domelement.php
    */
    public function getTextContent($xpath)
    {
        $text_contents = [];

        foreach ($this->getElements($xpath) as $element) {
            $text_contents[] = $element->textContent;
        }

        return $text_contents;
    }


    /*
    * Returns traversable object of DOMElement objects,
    * based on XPath expression provided.
    *
    * http://php.net/manual/en/domxpath.query.php
    */
    public function getElements($xpath)
    {
        if (!$this->DOMXPath->query($xpath)) {
                throw new \Exception("Unexpected error with XPATH -".$xpath);
        } else {
            return $this->DOMXPath->query($xpath);
        }
    }
}
