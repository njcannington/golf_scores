<?php
namespace App\Models\Tournament;

class Tournament
{
    protected $name;
    protected $par;
    protected $teams = [];

    public function __construct($name, $par)
    {
        $this->name = $name;
        $this->par = $par;
    }

    public function addTeam($team)
    {
        $this->teams[] = $team;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPar()
    {
        return $this->par;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function getAllGolfers()
    {
        $golfers = [];
        foreach ($this->teams as $team) {
            $golfers = array_merge($golfers, $team->getAllGolfers());
        }

        return $golfers;
    }
}
