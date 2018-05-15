<?php
namespace App\Models;

use App\Models\Golfer;

class Leaderboard
{
    protected $data;
    protected $tournament;

    public function __construct($url, $tournament)
    {
        $this->tournament = $tournament;
        $html = HTML::curlThis($url);
        $this->data = new DOMScraper($html);
    }

    public function extractTournamentPar()
    {
        $par_path = "//li[2]/div[@class='course-detail']/div[@class='type'][1]";
        $par_string = $this->data->getTextContent($par_path)[0];

        return intval(substr($par_string, -2));
    }

    public function extractTournamentName()
    {
        $name_path = "//header/div/div/h1";
        return $this->data->getTextContent($name_path)[0];
    }

    public function extractGolfers()
    {
        $golfers = [];
        foreach ($this->extractGolferRows() as $golfer_data) {
            $name = $this->extractGolferName($golfer_data);
            $rounds = $this->extractGolferRounds($golfer_data);
            $thru = $this->extractThru($golfer_data);

            $golfers[$name] = new Golfer($name, $rounds, $thru, $this->tournament);
        }

        return $golfers;
    }

    public function extractRoundsMax()
    {
        $max_rounds = [];
        foreach ($this->extractGolferRows() as $golfer_data) {
            $rounds = $this->extractGolferRounds($golfer_data);
            $max_rounds["current"][] = $rounds["current"];
            $max_rounds[1][] = $rounds[1];
            $max_rounds[2][] = $rounds[2];
            $max_rounds[3][] = $rounds[3];
            $max_rounds[4][] = $rounds[4];
        }

        $max_rounds["current"] = max($max_rounds["current"]);
        $max_rounds[1] = max($max_rounds[1]);
        $max_rounds[2] = max($max_rounds[2]);
        $max_rounds[3] = max($max_rounds[3]);
        $max_rounds[4] = max($max_rounds[4]);

        return $max_rounds;
    }


    /*
    * methods used to extract the individual golfer data from the table
    *
    */

    protected function extractGolferTable()
    {
        $golfer_path = "//tbody/tr[contains(@class,'player-overview')]";
        return $this->data->getElements($golfer_path);
    }

    protected function extractGolferRows()
    {
        $golfers = [];
        foreach ($this->extractGolferTable() as $golfer_element) {
            $golfers[] = $golfer_element->childNodes;
        }
        return $golfers;
    }

    protected function extractGolferName($golfer_data)
    {
        $name_data = $golfer_data[2]->childNodes;
        return $name_data[1]->textContent;
    }

    protected function extractGolferRounds($golfer_data)
    {
        $rounds = [];
        $rounds["current"] = intval($golfer_data[4]->textContent);
        $rounds[1] = intval($golfer_data[6]->textContent) - $this->tournament->getPar();
        $rounds[2] = intval($golfer_data[7]->textContent) - $this->tournament->getPar();
        $rounds[3] = intval($golfer_data[8]->textContent) - $this->tournament->getPar();
        $rounds[4] = intval($golfer_data[9]->textContent) - $this->tournament->getPar();

        return $rounds;
    }

    protected function extractThru($golfer_data)
    {
        return $golfer_data[5]->textContent;
    }





    public function __destruct()
    {
        $this->data = '';
    }

    // protected function getGolfers()
    // {
    //     $golfers = "//tbody/tr/td[contains(@class,'playerName')]/a[@class='full-name']";
    //     return $this->data->getTextContent($golfers);
    // }
    //
    // protected function
    //
    // public function extractThru($id)
    // {
    //     $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'thru')]";
    //
    //     return $this->data->getTextContent($score)[0];
    // }
    //
    // public function extractCurrent($id)
    // {
    //     $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'current')]";
    //
    //     return $this->data->getTextContent($score)[0];
    // }
    //
    // public function extractRound($round, $id)
    // {
    //     $score = "//tbody[contains(@id,'{$id}')]/tr/td[contains(@class, 'round{$round}')]";
    //
    //     return $this->data->getTextContent($score)[0];
    // }
    //
    // public function extractHighestScore($round)
    // {
    //     $score = "//tbody/tr/td[contains(@class, 'round{$round}')]";
    //     $max = max($this->data->getTextContent($score));
    //
    //     return $max;
    // }
    //
    // public function extractHighestCurrent()
    // {
    //     $scores = $this->getAllCurrentScores();
    //     $scores = array_replace($scores, array_fill_keys(array_keys($scores, "E"), 0));
    //     $scores = array_replace($scores, array_fill_keys(array_keys($scores, "-"), 0));
    //     $max = max($scores);
    //     return $max;
    // }
    //

    //
    // protected function getAllRoundScores($round)
    // {
    //     $score = "//tbody/tr/td[contains(@class, 'round{$round}')]";
    //     return $this->data->getTextContent($score);
    // }
}
