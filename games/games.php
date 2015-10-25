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

include("classes/game.php");
include("classes/media.php");

// controller + model part
$render = "list";
switch($_REQUEST["a"]) {
	case "edit":
		try {
			// FIXME this should be in the model
			// SQL SELECT jeu prets
			$sql = "SELECT jeu.id_jeu, nom, reference, fabricant, categorie, categorie_esar_id,
				commentaire, infos_fabricant, inventaire, date_achat, prix, nombre_mini, nombre_maxi,
				age_mini, age_maxi, type, id_pret
				FROM jeu
					LEFT OUTER JOIN prets ON (jeu.id_jeu = prets.id_jeu AND prets.rendu = 0)
				WHERE jeu.id_jeu = ".mysql_real_escape_string($_REQUEST["i"]);
			$data->select($sql, $game, "Game");
			if(sizeof($game)) {
				// get medias associated with it
				// SQL SELECT medias
				$sql = " SELECT id, description, media_type_id, file
					FROM medias
					WHERE id_jeu = ".mysql_real_escape_string($_REQUEST["i"]);
				$data->select($sql, $medias, "Media");
				$render = "games/edit";
			} else {
				$render = "games/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "views/data_exception";
		}
	break;
}

// view part
include($render.".php");
?>
