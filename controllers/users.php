<?php
$render = "users/loginform";
switch($_REQUEST["a"]) {
	case "login":
		$render = "user/loginform";
	break;
}

include("views/".$render.".php");
