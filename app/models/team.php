<?php
namespace App\Models;

use App\Models\Golfer;

class Team
{
    protected $name;
    protected $golfers = [];
    protected $tournament;

    public function __construct($name, $tournament)
    {
        $this->name = $name;
        $this->tournament = $tournament;
    }

    public function addGolfers($golfers = [])
    {
        foreach ($golfers as $golfer) {
            $golfer = $this->tournament->getGolfer($golfer);
            $golfer->addTeam($this);
            $golfer->updateScore();
            $name = $golfer->getName();
            $this->golfers[$name] = $golfer;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGolfers()
    {
        return $this->golfers;
    }

    public function getScore()
    {
        $scores = [];
        foreach ($this->golfers as $golfer) {
            $scores[] = $golfer->getTotal();
        }
        sort($scores);

        return $scores[0] + $scores[1] + $scores[2] + $scores[3];
    }
    //
    // public function getPrimaryGolfers()
    // {
    //     return $this->primary_golfers;
    // }
    //
    // public function getDraftedGolfers()
    // {
    //     return $this->drafted_golfers;
    // }
    //
    // public function getAllGolfers()
    // {
    //
    //     return array_merge($this->drafted_golfers, $this->primary_golfers);
    // }
    //

    //
    // public function getScore()
    // {
    //     return $this->score;
    // }
    //
    // protected function getPrimaryScore()
    // {
    //     $total = [];
    //     foreach ($this->primary_golfers as $primary) {
    //         $total[] = $primary->getTotal();
    //     }
    //
    //     return array_sum($total);
    // }
    //
    // protected function getDraftedScore()
    // {
    //     $total = [];
    //     foreach ($this->drafted_golfers as $drafted) {
    //         $total[] = $drafted->getTotal();
    //     }
    //     sort($total);
    //
    //     return $total[0] + $total[1];
    // }
    //
    // public function setScore()
    // {
    //     $primary_score = $this->getPrimaryScore();
    //     $drafted_score = $this->getDraftedScore();
    //
    //     $this->score = $primary_score + $drafted_score;
    // }
}
