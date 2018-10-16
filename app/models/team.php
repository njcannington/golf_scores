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
}
