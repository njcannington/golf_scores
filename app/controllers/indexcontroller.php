<?php
namespace App\Controllers;

use Lib\Config\Config;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Leaderboard;
use App\Models\Golfer;

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

        //ADD TOURNAMENT
        if (isset($_POST["tournament_url"])) {
            $this->addTournament($_POST["tournament_url"]);
        }

        //ADD TEAM
        if (isset($_POST["team_name"])) {
            $tournament = Tournament::findOne(["id" => $_POST["tournament_id"]]);
            $tournament->addTeam($_POST["team_name"]);
        }

        //ADD GOLFER
        if (isset($_POST["team_id"])) {
            $team = Team::findOne(["id" => $_POST["team_id"]]);
            $team->addGolfer($_POST["golfer_name"]);
            $tournament = Tournament::findOne(["id" => $team->tournament_id]);
            $teams = $tournament->getTeams();
            $leaderboard = new leaderboard($tournament->url);
            return compact("teams", "tournament","leaderboard");
        }

        //REMOVE GOLFER
        if (isset($_POST["golfer_id"])) {
            $golfer = Golfer::findOne(["id" => $_POST["golfer_id"]]);
            $tournament = Tournament::findOne(["id" => $golfer->tournament_id]);
            $teams = $tournament->getTeams();
            $leaderboard = new leaderboard($tournament->url);
            $golfer->remove();
            return compact("teams", "tournament","leaderboard");
        }

        if (isset($_POST["tournament_id"])) {
            $teams = $this->getTeams($_POST["tournament_id"]);
            $tournament = Tournament::findOne(["id" => $_POST["tournament_id"]]);
            $leaderboard = new leaderboard($tournament->url);
            return compact("teams", "tournament", "leaderboard");
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
