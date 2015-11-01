<?php
/*
This file is part of phpLudoreve.

    phpLudoreve is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    phpLudoreve is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with phpLudoreve.  If not, see <http://www.gnu.org/licenses/>.
*/

session_start();
function __autoload($class_name) {
    include "classes/".strtolower($class_name).".php";
}
include("config/config.php");
global $data;
$data = new data();
// this is a json-only zone
header("Content-Type: application/json");
$contexts = array("members" => "Adhérents", 
	"games" => "Jeux", 
	"esar_categories" => "Catégories ESAR");
if(!array_key_exists("o", $_REQUEST) || !array_key_exists($_REQUEST["o"], $contexts)) {
    // FIXME send correct HTTP code
    exit();
}
switch($_REQUEST["o"]) {
    case "games";
        include("controllers/games.php");
    break;

    case "members";
        include("controllers/members.php");
    break;

	case "esar_categories":
		include("controllers/esar_categories.php");
	break;

    default:
		//header("Location: ./accueil/index.php");
        ?>
        //include("accueil/index.php");
        <?php
    break;
}
?>
