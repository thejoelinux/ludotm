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
	case "new":
	case "create":
		$member = new Member(0);
		if($_REQUEST["a"] == "create") {
			$member->create();
		}
		$_REQUEST["i"] = $member->id_adherent;
		$render = "members/edit";
	break;

	case "update":
	case "edit":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["i"]));
			if($member->id_adherent != 0) {
				if($_REQUEST["a"] == "update") {
					$member->update();
					$_REQUEST["a"] = "edit";
				}
				$member->fetch_subscriptions();
				$member->fetch_loans();
                $render = "members/edit";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

    case "name_list": // for API
        try {
            Member::fetch_all($members);
            echo json_encode($members);
            exit(); // no further rendering needed 
		} catch(data_exception $e) {
			$render = "data_exception";
		}
    break;

	case "loans":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["i"]));
			if($member->id_adherent != 0) {
				$member->fetch_loans();
                $render = "members/loans";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "create_loan":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["id_adherent"]));
			if($member->id_adherent != 0) {
				$member->create_loan();
				$member->fetch_loans();
                $render = "members/loans";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "update_loan":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["member_id"]));
			if($member->id_adherent != 0) {
				$member->update_loan();
				$member->fetch_loans();
                $render = "members/loans";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "subscriptions":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["i"]));
			if($member->id_adherent != 0) {
				$member->fetch_subscriptions();
                $render = "members/subscriptions";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "create_subscription":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["member_id"]));
			if($member->id_adherent != 0) {
				$member->create_subscription();
				$member->fetch_subscriptions();
                $render = "members/subscriptions";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "update_subscription":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["member_id"]));
			if($member->id_adherent != 0) {
				$member->update_subscription();
				$member->fetch_subscriptions();
                $render = "members/subscriptions";
			} else {
				$render = "members/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

    default:
        try {
            Member::fetch_all($members);
            $render = "members/list";
        } catch(data_exception $e) {
			$render = "data_exception";
		}
    break;
}

// view part
include("views/".$render.".php");
?>
