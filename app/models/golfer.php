<?php
namespace App\Models;

class Golfer
{

    protected $name;
    protected $thru;
    protected $rounds;
    protected $team;
    protected $tournament;

    public function __construct($name, $rounds, $thru, $tournament)
    {
        $this->tournament = $tournament;
        $this->name = $name;
        $this->thru = $thru;
        $this->rounds = $rounds;
    }


    protected function addCutScores()
    {
        $rounds_max = $this->tournament->getRoundsMax();
        $this->addCurrent($rounds_max["current"]);
        $this->addRound1($this->rounds[1]);
        $this->addRound2($this->rounds[2]);
        $this->addRound3($rounds_max[3]);
        $this->addRound4($rounds_max[4]);
    }

    protected function isNotPlaying()
    {

        return in_array($this->thru, ["CUT", "MDF", "WD"]);
    }


    protected function addRound1($round1)
    {
        $this->rounds[1] = $round1;
    }

    protected function addRound2($round2)
    {
        $this->rounds[2] = $round2;
    }

    protected function addRound3($round3)
    {
        $this->rounds[3] = $round3;
    }

    protected function addRound4($round4)
    {
        $this->rounds[4] = $round4;
    }

    protected function addCurrent($current)
    {
        $this->rounds["current"] = $current;
    }

    protected function hasTeam()
    {
        return(!is_null($this->team));
    }

    public function getCurrent()
    {
        return $this->rounds["current"];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRounds()
    {
        $current_round =  $this->tournament->getCurrentRound();
        $rounds = $this->rounds;
        $rounds[$current_round] = $this->rounds["current"];
        unset($rounds["current"]);
        
        return $rounds;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getThru()
    {
        return $this->thru;
    }

    public function getTotal()
    {
        $current_round = $this->tournament->getCurrentRound();
        $rounds = $this->rounds;
        unset($rounds[$current_round]);

        return array_sum($rounds);
    }

    public function addTeam($team)
    {
        $this->team = $team;
    }

    public function updateScore()
    {
        if ($this->isNotPlaying()) {
            $this->addCutScores();
        }
    }
}
