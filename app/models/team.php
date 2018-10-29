<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;

class Team extends Model
{
    public $name = null;
    public $tournament_id = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = "teams";
        $this->columns = ["name", "tournament_id"];
    }

    // ADD PROPERTIES
    public function addTournament($tournament_id)
    {
        $this->tournament_id = $tournament_id;
    }

    public function addName($name)
    {
        $this->name = $name;
    }

    public function addGolfer($name)
    {
        $golfer = new Golfer();
        $golfer->addName($name);
        $golfer->addTeam($this->id);
        $golfer->addTournament($this->tournament_id);
        $golfer->save();
    }

    public function getGolfers()
    {
        return Golfer::findAll(["team_id" => $this->id, "tournament_id" => $this->tournament_id]);
    }
}