<?php
namespace App\Controllers;

use App\Models\Teams;
use App\Models\Leaderboard;
use App\Models\Tournament;

class IndexController
{
    public function indexAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard/_/tournamentId/401025263/season/2018");

        $tournament->addTeam("Gerry");
        $tournament->addTeam("Nic");
        $tournament->addTeam("Drew");
        $tournament->addTeam("Parker");
        
        $gerry = $tournament->getTeam("Gerry");
        $nic = $tournament->getTeam("Nic");
        $drew = $tournament->getTeam("Drew");
        $parker = $tournament->getTeam("Parker");
        
        $gerrys_golfers =
            ["Justin Thomas",
            "Hideki Matsuyama",
            "Tommy Fleetwood",
            "Francesco Molinari",
            "Xander Schauffele",
            "Marc Leishman"];
        $gerry->addGolfers($gerrys_golfers);
        
        $nics_golfers =
            ["Jordan Spieth",
            "Rickie Fowler",
            "Brooks Koepka",
            "Jon Rahm",
            "Matt Kuchar",
            "Joaquin Niemann"];
        $nic->addGolfers($nics_golfers);
        
        $drews_golfers =
            ["Rory McIlroy",
            "Tiger Woods",
            "Justin Rose",
            "Tony Finau",
            "Patrick Reed",
            "Alexander Noren"];
        $drew->addGolfers($drews_golfers);
        
        $parkers_golfers =
            ["Dustin Johnson",
            "Paul Casey",
            "Jason Day",
            "Henrik Stenson",
            "Patrick Cantlay",
            "Thorbjorn Olesen"];
        $parker->addGolfers($parkers_golfers);


        return compact("tournament");
    }

    public function usopenAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard?tournamentId=401025255");

        $tournament->addTeam("Gerry");
        $tournament->addTeam("Nic");
        $tournament->addTeam("Drew");
        $tournament->addTeam("Parker");
        
        $gerry = $tournament->getTeam("Gerry");
        $nic = $tournament->getTeam("Nic");
        $drew = $tournament->getTeam("Drew");
        $parker = $tournament->getTeam("Parker");
        
        $gerrys_golfers =
            ["Justin Thomas",
            "Hideki Matsuyama",
            "Jon Rahm",
            "Patrick Reed",
            "Adam Scott",
            "Bubba Watson"];
        $gerry->addGolfers($gerrys_golfers);
        
        $nics_golfers =
            ["Jordan Spieth",
            "Rickie Fowler",
            "Brooks Koepka",
            "Matt Kuchar",
            "Bryson DeChambeau",
            "Francesco Molinari"];
        $nic->addGolfers($nics_golfers);
        
        $drews_golfers =
            ["Rory McIlroy",
            "Tiger Woods",
            "Jason Day",
            "Henrik Stenson",
            "Branden Grace",
            "Louis Oosthuizen"];
        $drew->addGolfers($drews_golfers);
        
        $parkers_golfers =
            ["Dustin Johnson",
            "Paul Casey",
            "Justin Rose",
            "Phil Mickelson",
            "Tommy Fleetwood",
            "Sergio Garcia"];
        $parker->addGolfers($parkers_golfers);


        return compact("tournament");
    }

    public function playersAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard?tournamentId=401025250");

        $tournament->addTeam("Gerry");
        $tournament->addTeam("Nic");
        $tournament->addTeam("Drew");
        $tournament->addTeam("Parker");

        $gerry = $tournament->getTeam("Gerry");
        $nic = $tournament->getTeam("Nic");
        $drew = $tournament->getTeam("Drew");
        $parker = $tournament->getTeam("Parker");

        $gerrys_golfers =
            ["Justin Thomas",
            "Hideki Matsuyama",
            "Phil Mickelson",
            "Bryson DeChambeau",
            "Kevin Kisner",
            "Francesco Molinari"];
        $gerry->addGolfers($gerrys_golfers);

        $nics_golfers =
            ["Jordan Spieth",
            "Rickie Fowler",
            "Jason Day",
            "Matt Kuchar",
            "Bubba Watson",
            "Alexander Noren"];
        $nic->addGolfers($nics_golfers);

        $drews_golfers =
            ["Rory McIlroy",
            "Tiger Woods",
            "Jon Rahm",
            "Patrick Reed",
            "Sergio Garcia",
            "Louis Oosthuizen"];
        $drew->addGolfers($drews_golfers);

        $parkers_golfers =
            ["Dustin Johnson",
            "Henrik Stenson",
            "Justin Rose",
            "Zach Johnson",
            "Tommy Fleetwood",
            "Kyle Stanley"];
        $parker->addGolfers($parkers_golfers);


        return compact("tournament");
    }

    public function openAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard?tournamentId=401025259");

        $tournament->addTeam("Gerry");
        $tournament->addTeam("Nic");
        $tournament->addTeam("Drew");
        $tournament->addTeam("Parker");
        
        $gerry = $tournament->getTeam("Gerry");
        $nic = $tournament->getTeam("Nic");
        $drew = $tournament->getTeam("Drew");
        $parker = $tournament->getTeam("Parker");
        
        $gerrys_golfers =
            ["Justin Thomas",
            "Hideki Matsuyama",
            "Tommy Fleetwood",
            "Brooks Koepka",
            "Francesco Molinari",
            "Zach Johnson"];
        $gerry->addGolfers($gerrys_golfers);
        
        $nics_golfers =
            ["Jordan Spieth",
            "Rickie Fowler",
            "Sergio Garcia",
            "Patrick Reed",
            "Jason Day",
            "Bryson DeChambeau"];
        $nic->addGolfers($nics_golfers);
        
        $drews_golfers =
            ["Rory McIlroy",
            "Tiger Woods",
            "Jon Rahm",
            "Henrik Stenson",
            "Branden Grace",
            "Tyrrell Hatton"];
        $drew->addGolfers($drews_golfers);
        
        $parkers_golfers =
            ["Dustin Johnson",
            "Paul Casey",
            "Justin Rose",
            "Marc Leishman",
            "Alexander Noren",
            "Russell Knox"];
        $parker->addGolfers($parkers_golfers);


        return compact("tournament");
    }

    public function pgaAction()
    {
        $tournament = new Tournament("http://www.espn.com/golf/leaderboard?tournamentId=401025263");

        $tournament->addTeam("Gerry");
        $tournament->addTeam("Nic");
        $tournament->addTeam("Drew");
        $tournament->addTeam("Parker");
        
        $gerry = $tournament->getTeam("Gerry");
        $nic = $tournament->getTeam("Nic");
        $drew = $tournament->getTeam("Drew");
        $parker = $tournament->getTeam("Parker");
        
        $gerrys_golfers =
            ["Justin Thomas",
            "Hideki Matsuyama",
            "Tommy Fleetwood",
            "Francesco Molinari",
            "Xander Schauffele",
            "Marc Leishman"];
        $gerry->addGolfers($gerrys_golfers);
        
        $nics_golfers =
            ["Jordan Spieth",
            "Rickie Fowler",
            "Brooks Koepka",
            "Jon Rahm",
            "Matt Kuchar",
            "Joaquin Niemann"];
        $nic->addGolfers($nics_golfers);
        
        $drews_golfers =
            ["Rory McIlroy",
            "Tiger Woods",
            "Justin Rose",
            "Tony Finau",
            "Patrick Reed",
            "Alexander Noren"];
        $drew->addGolfers($drews_golfers);
        
        $parkers_golfers =
            ["Dustin Johnson",
            "Paul Casey",
            "Jason Day",
            "Henrik Stenson",
            "Patrick Cantlay",
            "Thorbjorn Olesen"];
        $parker->addGolfers($parkers_golfers);


        return compact("tournament");
    }


}
