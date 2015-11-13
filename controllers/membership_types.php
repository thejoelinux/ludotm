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
		try {
			Membership_Type::fetch_all($membership_types);
			if($format == "json") {
				echo json_encode($membership_types);
				exit(); // no further rendering needed 
			} else {
				$render = "membership_types/list";
			}
		} catch(data_exception $e) {
			header($_SERVER['SERVER_PROTOCOL'] . ' Internal Server Error', true, 500);
			exit(); // no further rendering needed 
		}
    break;

	case "create":
		try {
			$membership_type = new Membership_Type(0);
			$membership_type->create();
	
			Membership_Type::fetch_all($membership_types);
			$render = "membership_types/list";
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "new":
		$membership_type = new Membership_Type(0);
		$_REQUEST["i"] = 0;
		$render = "membership_types/edit";
	break;

	case "delete":
		try {
			if($_REQUEST["i"] = Membership_Type::delete($_REQUEST["i"])) {
				Membership_Type::fetch_all($membership_types);
				$render = "membership_types/list";
			} else {
				$render = "unprocessable";
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "update":
		try {
            $membership_type = Membership_Type::fetch($data->db_escape_string($_REQUEST["i"]));
			if($membership_type->id != 0) {
				$membership_type->update();
				Membership_Type::fetch_all($membership_types);
				$render = "membership_types/list";
			} else {
				$render = "membership_types/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "edit":
		try {
            $membership_type = Membership_Type::fetch($data->db_escape_string($_REQUEST["i"]));
			if($membership_type->id != 0) {
				$render = "membership_types/edit";
			} else {
				$render = "membership_types/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;
}
// view part
include("views/".$render.".php");
?>
