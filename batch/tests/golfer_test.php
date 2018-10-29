<?php
$dirs = explode("/", dirname(__FILE__));
$batch = array_search("batch", $dirs);
$batch_location = implode("/", array_slice($dirs, 0, $batch+1));

require($batch_location."/test_requirements.php");

use App\Models\Tournament;
use App\Models\Team;
use App\Models\Golfer;


$tournament = Tournament::findOne(["name" => "The Open"]);
$team = Team::findOne(["name" => "Golfer_1", "tournament_id" => $tournament->id]);
$team->addGolfer("Tiger Woods");