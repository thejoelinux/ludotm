<?php
// controller 
$render = "list";
switch($_REQUEST["a"]) {
	case "new":
	case "create":
		$member = new Member(0);
		if($_REQUEST["a"] == "create") {
			$member->create();
		}
		$_REQUEST["i"] = $member->id;
		$render = "members/edit";
	break;

	case "update":
	case "edit":
		try {
            $member = Member::fetch($data->db_escape_string($_REQUEST["i"]));
			if($member->id != 0) {
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

	case "birthdays": // for API
		try {
			$rset = Member::fetch_birthdays();
			echo $rset->to_json();
            exit(); // no further rendering needed
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
			if($member->id != 0) {
				$member->fetch_subscriptions();
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
            $member = Member::fetch($data->db_escape_string($_REQUEST["member_id"]));
			if($member->id != 0) {
				$member->fetch_subscriptions();
				if($member->has_valid_subscription()) {
					$member->create_loan();
					$member->fetch_loans();
				} // no error message - normally you can't do this
				$_REQUEST["i"] = $member->id;
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
			if($member->id != 0) {
				$member->fetch_subscriptions();
				$member->update_loan();
				$member->fetch_loans();
				$_REQUEST["i"] = $member->id;
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
			if($member->id != 0) {
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
			if($member->id != 0) {
				$member->create_subscription();
				$member->fetch_subscriptions();
				$_REQUEST["i"] = $member->id;
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
			if($member->id != 0) {
				$member->update_subscription();
				$member->fetch_subscriptions();
				$_REQUEST["i"] = $member->id;
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
