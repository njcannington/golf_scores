<?php
require "../autoload.php";

use Lib\Bootstrap\Bootstrap;

session_start();

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

// set privs to false by default
$data["admin"] = false;
$data["auth"] = false;
 
// check for admin priv
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
    $data["admin"] = true;
    $data["auth"] = true;
}

// check for auth priv
if (isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    $data["auth"] = true;
}

require_once(VIEWS."/layout.html");
