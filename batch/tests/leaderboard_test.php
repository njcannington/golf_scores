<?php
$dirs = explode("/", dirname(__FILE__));
$batch = array_search("batch", $dirs);
$batch_location = implode("/", array_slice($dirs, 0, $batch+1));

require($batch_location."/test_requirements.php");

use App\Models\Leaderboard;
use App\Models\Tournament;


$tournament = Tournament::findOne(["name" => "2018 Masters Tournament"]);
$leaderboard = new leaderboard($tournament->url);
echo $leaderboard->getRoundMax(1);