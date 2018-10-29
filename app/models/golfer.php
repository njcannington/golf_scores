<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;

class Golfer extends Model
{
    public $name = null;
    public $team_id = null;
    public $tournament_id = null;

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
}