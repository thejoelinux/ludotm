<?php
if($logged_user->id == 0) {
	$render = "users/loginform";
} else {
	switch($_REQUEST["a"]) {
		case "new":
			$user = new User(0);
			$_REQUEST["i"] = $user->id;
			$render = "users/edit";
		break;

        case "create":
            $user = new User(0);
            $user->create();
            $user = User::fetch($user->id);
            $user->update_roles();
            $users = array();
            User::fetch_all($users);
		    $render = "users/list";
        break;            

        case "update":
            try {
                $user = User::fetch($data->db_escape_string($_REQUEST["i"]));
                if($user->id != 0) {
                    $user->update();
                    $user->update_roles();
                    User::fetch_all($users);
                    $render = "users/list";
                } else {
                    $render = "users/not_found"; // TODO
                }
            } catch(data_exception $e) {
                $render = "data_exception";
            }
        break;          
	
		case "edit":
			try {
				if($user->id == $data->db_escape_string($_REQUEST["i"])) {
					$render = "users/edit";
				} else {
					$user = User::fetch($data->db_escape_string($_REQUEST["i"]));
					if($user->id != 0) {
						$render = "users/edit";
					} else {
						$render = "users/not_found"; // TODO
					}
				}
			} catch(data_exception $e) {
				$render = "data_exception";
			}
		break;

		case "login":
			$render = "users/loginform";
		break;

        case "switch_state": // API CALL
            try {
                $user = User::fetch($data->db_escape_string($_REQUEST["i"]));
                if($user->id != 0) {
                    $user->change_state($data->db_escape_string($_REQUEST["state"]));
                    echo json_encode($user);
                    exit();
                } else {
                    $render = "unprocessable";
                }
            } catch(data_exception $e) {
                $render = "data_exception";
            }
        break;


		default:
			try {
				User::fetch_all($users);
				$render = "users/list";
			} catch(data_exception $e) {
				$render = "data_exception";
			}
		break;

	}
}

include("views/".$render.".php");
