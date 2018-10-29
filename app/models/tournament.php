<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;
use App\Models\Team;

class Tournament extends Model
{
    public $name;
    public $url;

    public function __construct()
    {
        parent::__construct();
        $this->table = "tournaments";
        $this->columns = ["url","name"];
    }

    public function getTeams()
    {
        return Team::findAll(["tournament_id" => $this->id]);
    }

    // OTHER METHODS

    public function addTeam($team_name)
    {
        $team = new Team();
        $team->addName($team_name);
        $team->addTournament($this->id);
        $team->save();
    }

    public function create($url)
    {
        $this->url = $url;
        $this->leaderboard = new Leaderboard($url);
        $this->name = $this->leaderboard->getName();
    }
}