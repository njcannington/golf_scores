<?php
namespace App\Models;

class Golfer
{
    protected $id;
    protected $name;
    protected $round = [];
    protected $total;
    protected $thru;

    public function __construct($golfer = [])
    {
        $this->name = key($golfer);
        $this->id = $golfer[$this->name];
    }

    public function setFourRounds($leaderboard, $par)
    {
        for ($round = 1; $round <5; $round++) {
            if ($round == 1) {
                $this->setCurrent($leaderboard);
            } else {
                $this->setRound($round, $leaderboard, $par);
            }
        }
    }

    public function setRound($round, $leaderboard, $par)
    {
        $score = $leaderboard->extractRound($round, $this->id);
        if (is_int($score)) {
            $this->round[$round] = $par - $score;
        } else {
            $this->round[$round] = "-";
        }
    }

    public function setThru($leaderboard)
    {
        $this->thru = $leaderboard->extractThru($this->id);
    }

    public function setCurrent($leaderboard)
    {
        $this->round[1] = $leaderboard->extractCurrent($this->id);
    }

    public function setTotal()
    {
        $this->total = array_sum($this->round);
    }

    protected function getCutScore($leaderboard)
    {
        $total = $this->round[1] + $this->round[2];
        $total = $total + $leaderboard->extractHighestScore(3);
        $total = $total + $leaderboard->extractHighestScore(4);

        return $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getThru()
    {
        return $this->thru;
    }

    public function getRounds()
    {
        return $this->round;
    }

    public function getName()
    {
        return $this->name;
    }
}
