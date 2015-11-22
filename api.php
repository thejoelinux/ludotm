<?php
session_start();
function __autoload($class_name) {
    include "classes/".strtolower($class_name).".php";
}
include("config/config.php");
global $data;
$data = new data();
global $logged_user;
$logged_user = new User(0);
if(!array_key_exists("user_id", $_SESSION)) { 
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Not Authorized', true, 403);
    exit();
} else {
    $logged_user = User::fetch($_SESSION["user_id"]);
}
// this is a json-only zone
header("Content-Type: application/json");
if(array_key_exists("o", $_REQUEST) && $_REQUEST["o"] != ""
	&& file_exists("controllers/".$_REQUEST["o"].".php")) {
        include("controllers/".$_REQUEST["o"].".php");
} else {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
}
?>
