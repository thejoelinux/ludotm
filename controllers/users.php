<?php
if($user->id == 0) {
	$render = "users/loginform";
} else {
	switch($_REQUEST["a"]) {
	
		case "edit":
			try {
				if($user->id == $data->db_escape_string($_REQUEST["i"])) {
					$luser = $user;
					$render = "users/edit";
				} else {
					$luser = User::fetch($data->db_escape_string($_REQUEST["i"]));
					if($luser->id != 0) {
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
