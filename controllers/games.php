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
		$game = new Game(0);
		if($_REQUEST["a"] == "create") {
			$game->create();
		}
		$_REQUEST["i"] = $game->id_jeu;
		$render = "games/edit";
	break;

	case "edit_medias":
	case "update":
	case "edit":
		try {
            $game = Game::fetch($data->db_escape_string($_REQUEST["i"]));
			if($game->id_jeu != 0) {
				if($_REQUEST["a"] == "update") {
					$game->update();
					$_REQUEST["a"] = "edit";
				}
				$render = "games/".$_REQUEST["a"];
			} else {
				$render = "games/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

    case "name_list": // for API
        try {
            Game::fetch_all($games);
            echo json_encode($games);
            exit(); // no further rendering needed 
		} catch(data_exception $e) {
			$render = "data_exception";
		}
    break;
	
	case "delete":
		// FIXME : make a screen to confirm the deletion of the game
		// and all the things w/it, like : medias, comments, lends...
		$render = "games/confirm_delete";
	break;

	case "confirm_delete":
		// FIXME : call the model, delete depedants items
		// and the game itself
		$render = "games/list";
	break;

    default:
        try {
            Game::fetch_all($games);
            $render = "games/list";
        } catch(data_exception $e) {
			$render = "data_exception";
		}
    break;
}

// view part
include("views/".$render.".php");
?>
