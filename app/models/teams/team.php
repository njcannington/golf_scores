<?php
namespace App\Models\Teams;

use App\Models\Golfer;

class Team
{
    protected $name;
    protected $score = 0;
    protected $primary_golfers = [];
    protected $drafted_golfers = [];

    public function getPrimaryGolfers()
    {
        return $this->primary_golfers;
    }

    public function getDraftedGolfers()
    {
        return $this->drafted_golfers;
    }

    public function getAllGolfers()
    {

        return array_merge($this->drafted_golfers, $this->primary_golfers);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getScore()
    {
        return $this->score;
    }

    protected function getPrimaryScore()
    {
        $total = [];
        foreach ($this->primary_golfers as $primary) {
            $total[] = $primary->getTotal();
        }

        return array_sum($total);
    }

    protected function getDraftedScore()
    {
        $total = [];
        foreach ($this->drafted_golfers as $drafted) {
            $total[] = $drafted->getTotal();
        }
        sort($total);

        return $total[0] + $total[1];
    }

    public function setScore()
    {
        $primary_score = $this->getPrimaryScore();
        $drafted_score = $this->getDraftedScore();

        $this->score = $primary_score + $drafted_score;
    }

    protected function addGolfer($type, $golfer = [])
    {
        $golfer = new Golfer($golfer);
        if ($type == "primary") {
            $this->primary_golfers[] = $golfer;
        } elseif ($type == "drafted") {
            $this->drafted_golfers[] = $golfer;
        }
    }
}
