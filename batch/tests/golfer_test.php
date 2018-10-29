<?php
$dirs = explode("/", dirname(__FILE__));
$batch = array_search("batch", $dirs);
$batch_location = implode("/", array_slice($dirs, 0, $batch+1));

require($batch_location."/test_requirements.php");

use App\Models\Tournament;
use App\Models\Team;
use App\Models\Golfer;


$golfer = Golfer::findOne(["tournament_id" => 2, "name" => "Jordan Spieth"]);
$score = $golfer->getScore();
echo $score->getRound(1);