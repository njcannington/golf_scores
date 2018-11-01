<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;

class Golfer extends Model
{
    public $name = null;
    public $team_id = null;
    public $tournament_id = null;
    protected $leaderboard;

    public function __construct()
    {
        parent::__construct();
        $this->table = "golfers";
        $this->columns = ["name", "team_id", "tournament_id"];
    }

    // ADD PROPERTIES

    public function addName($name)
    {
        $this->name = $name;
    }

    public function addTournament($tournament_id)
    {
        $this->tournament_id = $tournament_id;
    }

    public function addTeam($team_id)
    {
        $this->team_id = $team_id;
    }

    public function setScore($leaderboard)
    {
        $this->leaderboard = $leaderboard;
    }

    public function getTeam()
    {
        return Team::findOne(["id" => $this->team_id]);
    }

    public function getRound($i)
    {
        if ($i > 2 && $this->isNotPlaying()) {
            return $this->leaderboard->getRoundMax($i) - $this->leaderboard->getPar();
        }
        $score = $this->leaderboard->getGolfer($this);
        return  $score->getRound($i) - $this->leaderboard->getPar();
    }

    public function getTotal()
    {
        for ($round = 1; $round <= 4; $round++) {
            $rounds[] = $this->getRound($round);
        }
        $total = array_sum($rounds);
        return $total;
    }

    public function getThru()
    {
        $score = $this->leaderboard->getGolfer($this);
        
        return $score->getThru();
    }

    public function isNotPlaying()
    {
        $score = $this->leaderboard->getGolfer($this);
        return in_array($score->getThru(), ["CUT", "MDF", "WD"]);
    }
}