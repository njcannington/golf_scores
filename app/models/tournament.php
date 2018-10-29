<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;
use App\Models\Team;

class Tournament extends Model
{
    public $name;
    public $url;
    protected $leaderboard;

    public function __construct()
    {
        parent::__construct();
        $this->table = "tournaments";
        $this->columns = ["url","name"];
    }

    // GET PROPERTIES
    public function getLeaderboard()
    {
        return $this->leaderboard;
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