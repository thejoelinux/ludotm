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

// controller 
$render = "list";
// format
$format = (preg_match("/api.php/", $_SERVER["REQUEST_URI"])) ? "json" : "html";

switch($_REQUEST["a"]) {
	case "list": // for API or HTML
		if($format == "json") {
        	try {
            	Membership_Type::fetch_all($membership_types);
	            echo json_encode($membership_types);
				exit(); // no further rendering needed 
			} catch(data_exception $e) {
				header($_SERVER['SERVER_PROTOCOL'] . ' Internal Server Error', true, 500);
				exit(); // no further rendering needed 
			}
		} else {
			// as there is not many fields
			// no prefetching - display a table, fill it with ajax call
			// add/edit rows with ajax call
			$render = "membership_types/list";
		}
    break;
}
// view part
include("views/".$render.".php");
?>
