<?php
namespace App\Models;

class Leaderboard
{
    const JT = "-4848";
    const HIDEKI = "-5860";
    const ROSE = "-569";
    const KUCH = "-257";
    const ADAM = "-388";
    const BERG = "-9025";
    const RORY = "-3470";
    const TIGER = "-462";
    const SERG = "-158";
    const RAHM = "-9780";
    const REED = "-5579";
    const KISNER = "-2552";
    const JORDAN = "-5467";
    const FOWLER = "-3702";
    const DAY = "-1680";
    const PHIL = "-308";
    const STENSON = "-576";
    const BRYSON = "-10046";
    const DJ = "-3448";
    const ZJ = "-686";
    const CASEY = "-72";
    const BUBBA = "-780";
    const NOREN = "-3832";
    const FLEETWOOD = "-5539";
    const HARMAN = "-1225";
    const FRANKIE = "-1483";
    const OOST = "-1293";
    const STANLEY = "-1778";
    const LEADERBOARD = "http://www.espn.com/golf/leaderboard";

    protected $data;

    public function __construct()
    {
        $html = HTML::curlThis(self::LEADERBOARD);
        $this->data = new DOMScraper($html);
    }

    public function extractThru($id)
    {
        $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'thru')]";

        return $this->data->getTextContent($score)[0];
    }

    public function extractCurrent($id)
    {
        $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'current')]";

        return $this->data->getTextContent($score)[0];
    }

    public function extractRound($round, $id)
    {
        $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'round{$round}')]";

        return $this->data->getTextContent($score)[0];
    }

    public function extractHighestScore($round)
    {
        $score = "//tbody/tr/td[contains(@class, 'round{$round}')]";
        $max = max($this->data->getTextContent($score));
        switch ($max) {
            case '--':
                $max = 0;
                break;

            default:
                $max = int($max);
                break;
        }
        return $max;
    }

    public function extractHighestCurrent()
    {
        $score = "//tbody/tr/td[contains(@class, 'current')]";
        $max = max($this->data->getTextContent($score));
        switch ($max) {
            case '--':
                $max = 0;
                break;

            default:
                $max = int($max);
                break;
        }
        return $max;
    }
}
