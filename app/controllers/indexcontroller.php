<?php
namespace App\Controllers;

use App\Models\Teams;
use App\Models\Leaderboard;
use App\Models\Tournament\Tournament;

class IndexController
{
    public function indexAction()
    {
        $tournament = new Tournament("The Players", 72);

        //establish leaderboard
        $leaderboard = new Leaderboard();

        //add 4 teams to tournament
        $tournament->addTeam(new Teams\Gerry());
        $tournament->addTeam(new Teams\Nic());
        $tournament->addTeam(new Teams\Parker());
        $tournament->addTeam(new Teams\Drew());

        $teams = $tournament->getTeams();

        //get scores foreach golfer from leaderboad
        foreach ($tournament->getAllGolfers() as $golfer) {
            $golfer->setFourRounds($leaderboard, $tournament->getPar());
            $golfer->setTotal($leaderboard);
            $golfer->setThru($leaderboard);
            $golfer->setTotal();
        }

        foreach ($teams as $team) {
            $team->setScore();
        }

        return compact("teams");
    }
}
