<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;

class Leaderboard extends Model
{
    protected $name;
    protected $par;
    protected $scores;

    public function __construct($url)
    {
        $html = HTML::curlThis($url);
        $dom = new DOMScraper($html);
        $this->setName($dom);
        $this->setPar($dom);
        $this->setScores($dom);
    }

    // SET PROPERTIES 
    protected function setName($dom)
    {
        $path = "//div/div/h1";
        $this->name = $dom->getTextContent($path)[0];
    }

    protected function setPar($dom)
    {
        $path = "//div[contains(@class,'Leaderboard__Course__Location__Detail')]/text()[1]";
        $this->par = intval($dom->getTextContent($path)[0]);
    }

    protected function setScores($dom)
    {
        $path = "//tbody[@class='Table2__tbody']/tr";
        $this->scores = $dom->tableToArray($path);
    }


    // GET PROPERTIES
    public function getName()
    {
        return $this->name;
    }


    public function getPar()
    {
        return $this->par;
    }

    public function getScores()
    {
        return $this->scores;
    }
}