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
switch($_REQUEST["a"]) {
	case "add": // for API
		$family_member = new Family_Member();
		if($_REQUEST["fm_firstname"] != "" && $_REQUEST["fm_lastname"] != ""
			&& $_REQUEST["fm_birthdate"] != "" && $_REQUEST["fm_link_id"] != "") {
			try {
				$family_member->create(
					$GLOBALS["data"]->db_escape_string($_REQUEST["fm_firstname"]), 
					$GLOBALS["data"]->db_escape_string($_REQUEST["fm_lastname"]),
					$GLOBALS["data"]->db_escape_string($_REQUEST["fm_birthdate"]), 
					$GLOBALS["data"]->db_escape_string($_REQUEST["fm_link_id"]));

				$render = "json/list";
			} catch(data_exception $e) {
				$render = "data_exception";
			}
		} else {
			$render = "unprocessable";
		}
	break;

	case "delete":
		if($_REQUEST["i"] = Family_Member::delete($GLOBALS["data"]->db_escape_string($_REQUEST["i"]))) {
			$render = "json/list";
		} else {
			$render = "unprocessable";
		}
	break;		

	case "list": // for API
		$render = "json/list";
	break;
}

if($render == "json/list") {
	$family_members = array();
	Family_Member::fetch_all($family_members, $_REQUEST["i"]);
	echo json_encode($family_members);
	exit(); // no further rendering needed 
}

// view part
include("views/".$render.".php");
?>
