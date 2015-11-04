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
if(array_key_exists("o", $_REQUEST) && $_REQUEST["o"] != ""
	&& file_exists("controllers/".$_REQUEST["o"].".php")) {
        include("controllers/".$_REQUEST["o"].".php");
} else {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
}
?>
