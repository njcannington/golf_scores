<?php
namespace App\Models;

use App\Models\Golfer;

class Leaderboard
{
    protected $data;
    protected $round;
    protected $tournament;

    public function __construct($url, $tournament)
    {
        $this->tournament = $tournament;
        $html = HTML::curlThis($url);
        $this->data = new DOMScraper($html);
    }

    public function isReady()
    {
        $footnote_path = "//article[2]/div/div/div/div/div/div";
        if (isset($this->data->getTextContent($footnote_path)[0])) {
            $footnote_string = $this->data->getTextContent($footnote_path)[0];
        } else {
            $footnote_string = '';
        }

        if ($footnote_string !== "NO TOURNAMENT DATA AVAILABLE") {
            return true;
        } else { 
            return false;
        }
    }

    public function extractTournamentPar()
    {
        $par_path = "//article[1]/div/div[@class='Leaderboard__Header']/div/div/div/div/div/span[1]";
        $par_string = $this->data->getTextContent($par_path)[0];

        return intval(substr($par_string, -2));
    }

    public function extractTournamentName()
    {
        $name_path = "//div/div/h1";
        return $this->data->getTextContent($name_path)[0];
    }

    public function extractGolfers()
    {
        $golfers = [];
        $i = 1;
        foreach ($this->extractGolferRows() as $golfer_data) {
            $name = $golfer_data[1]->textContent;
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
    public function setCurrentRound()
    {
        $round_path = "//h2/span[@class='tournament-status']";
        $text = $this->data->getElements($round_path);
        $round_text = $text[0]->textContent;
        if (substr($round_text, 0, 5) == "Round") {
            return intval(substr($round_text, 6, 1));
        } else {
            return "n/a";
        }
    }

    protected function extractGolferTable()
    {
        $golfer_path = "//table/tbody/tr/td/table/tbody/tr";
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

    protected function extractGolferRounds($golfer_data)
    {
        $rounds = [];
        // $rounds["current"] = intval($golfer_data[4]->textContent);
        $rounds["current"] = '';
        $rounds[1] = $this->calcRoundScore($golfer_data[3]->textContent);
        $rounds[2] = $this->calcRoundScore($golfer_data[4]->textContent);
        $rounds[3] = $this->calcRoundScore($golfer_data[5]->textContent);
        $rounds[4] = $this->calcRoundScore($golfer_data[6]->textContent);

        return $rounds;
    }

    protected function calcRoundScore($score)
    {
        if ($score == "--") {
            return "--";
        } else {
            return intval($score - $this->extractTournamentPar());
        }
    }

    protected function extractThru($golfer_data)
    {
        return $golfer_data[5]->textContent;
    }





    public function __destruct()
    {
        $this->data = '';
    }
}
