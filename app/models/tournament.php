<?php
namespace App\Models;

use App\Models\Leaderboard;
use App\Models\Team;

class Tournament
{
    protected $name;
    protected $par;
    protected $teams = [];
    protected $golfers = [];
    protected $current_round;
    protected $current_max;
    protected $rounds_max = [];

    public function __construct($url)
    {
        $leaderboard = new Leaderboard($url, $this);
        $this->name = $leaderboard->extractTournamentName();
        $this->par = $leaderboard->extractTournamentPar();
        $this->rounds_max = $leaderboard->extractRoundsMax();
        $this->golfers = $leaderboard->extractGolfers();
        $this->current_round = $this->setCurrentRound();
    }

    protected function setCurrentRound()
    {
        $rand_name = array_rand($this->golfers);
        $rand_golfer = $this->getGolfer($rand_name);
        $rounds = $rand_golfer->getRounds();
        for ($round = 4; $round > 0; $round--) {
            if ($rounds[$round] !== "--") {
                return $round;
            }
        }
    }

    public function addTeam($team)
    {
        $this->teams[$team] = new Team($team, $this);
    }

    public function getGolfer($golfer)
    {
        return $this->golfers[$golfer];
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function getTeam($name)
    {
        return $this->teams[$name];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPar()
    {
        return $this->par;
    }

    public function getCurrentRound()
    {
        return $this->current_round;
    }

    public function getCurrentMax()
    {
        return $this->current_max;
    }

    public function getRoundsMax()
    {
        return $this->rounds_max;
    }
}
