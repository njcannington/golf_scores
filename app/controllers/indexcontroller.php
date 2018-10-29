<?php
namespace App\Controllers;

use Lib\Config\Config;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Leaderboard;

class IndexController
{

    public function indexAction()
    {
        return [];
    }

    public function draftAction()
    {
        $config = Config::getInstance();
        $passwords = $config["passwords"];


        if (isset($_POST["pass"]) && strtolower($_POST["pass"]) == $passwords["user"]) {
            $_SESSION["auth"] = true;
        }

        if (isset($_POST["pass"]) && strtolower($_POST["pass"]) == $passwords["admin"]) {
            $_SESSION["auth"] = true;
            $_SESSION["admin"] = true;
        }

        if (isset($_POST["tournament_url"])) {
            $this->addTournament($_POST["tournament_url"]);
        }

        if (isset($_POST["team_name"])) {
            $tournament = Tournament::findOne(["id" => $_POST["tournament_id"]]);
            $tournament->addTeam($_POST["team_name"]);
        }

        if (isset($_POST["tournament_id"])) {
            $teams = $this->getTeams($_POST["tournament_id"]);
            $tournament = Tournament::findOne(["id" => $_POST["tournament_id"]]);
            return compact("teams", "tournament");
        }

        if (isset($_POST["team_id"])) {
            $team = Team::findOne(["id" => $_POST["team_id"]]);
            $team->addGolfer($_POST["golfer"]);
            $teams = $this->getTeams($team->tournament_id);
            $tournament = Tournament::findOne(["id" => $team->tournament_id]);
            return compact("teams", "tournament");
        }
    }

    public function tournamentAction()
    {
        $tournament = Tournament::findOne(["id" => $_GET["id"]]);
        $leaderboard = new leaderboard($tournament->url);
        return compact("tournament", "leaderboard");
    }

    public function addTournament($url)
    {
        $tournament = new Tournament();
        $tournament->create($url);
        $tournament->save();
    }

    public function getTeams($tournament_id)
    {
        return Team::findAll(["tournament_id" => $tournament_id]);
    }
}
