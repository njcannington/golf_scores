<?php
namespace App\Controllers;

use App\Models\Teams;
use App\Models\Leaderboard;
use App\Models\Tournament;

class IndexController
{
    public function indexAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard");

        return compact("tournament");
    }
}
