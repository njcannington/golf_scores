<?php
require "../autoload.php";

use Lib\Bootstrap\Bootstrap;

// grabs URI
if (!isset($_GET["q"])) {
    $uri = 'index';
} else {
    $uri = $_GET["q"];
}

// routing
$bootstrap = new Bootstrap($uri);
$action = $bootstrap->request->action."Action";
$data = $bootstrap->controller->$action();


require_once(VIEWS."/layout.html");
