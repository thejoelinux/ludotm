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

// controller part
switch($_REQUEST["a"]) {
	case "edit":
		// SQL SELECT jeu
		$sql = "SELECT id_jeu, nom, reference, fabricant, categorie, categorie_esar_id,
            commentaire, infos_fabricant, inventaire, date_achat, prix, nombre_mini, nombre_maxi,
            age_mini, age_maxi, type
        	FROM jeu WHERE id_jeu = ".mysql_real_escape_string($_REQUEST["i"]);
		$data->select($sql, $rset);
		if($rset->numrows) {
        	// get medias associated with it
	        // SQL SELECT media
    	    $sql = " SELECT id, description, media_type_id, file
        	    FROM medias
            	WHERE id_jeu = ".mysql_real_escape_string($_REQUEST["i"]);
			$data->select($sql, $media_rset);
		} else {
			$media_rset = "";
		}
	break;
}

// view part
switch($_REQUEST["a"]) {
	case "edit":
		include("games/edit.php");
	break;

	default: // list
		include("games/list.php");
	break;
}
?>
