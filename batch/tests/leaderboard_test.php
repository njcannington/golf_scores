<?php
$dirs = explode("/", dirname(__FILE__));
$batch = array_search("batch", $dirs);
$batch_location = implode("/", array_slice($dirs, 0, $batch+1));

require($batch_location."/test_requirements.php");

use App\Models\Leaderboard;
use App\Models\Tournament;


$url = "http://www.espn.com/golf/leaderboard/_/tournamentId/401025259";
$leaderboard = new Leaderboard($url);
echo $leaderboard->getName()."\n";
echo $leaderboard->getPar()."\n";
// print_r($leaderboard->getGolferData("Jon Rahm"));