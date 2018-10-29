<?php
$dirs = explode("/", dirname(__FILE__));
$batch = array_search("batch", $dirs);
$batch_location = implode("/", array_slice($dirs, 0, $batch+1));

require($batch_location."/test_requirements.php");

use App\Models\Tournament;

$tournament = new Tournament();
$tournament->create("http://www.espn.com/golf/leaderboard/_/tournamentId/401025259");
$tournament->save();


