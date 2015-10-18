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

	include "entt.php";
	
	$sql = "SELECT prets.id_pret,prets.rendu,prets.date_retour,prets.id_jeu,
			prets.id_adherent,prets.reglera
			FROM prets
			WHERE id_jeu='".mysql_real_escape_string($_GET['id_jeu'],$server_link)."'";
		echo "<h1>PRETS DU JEU</h1>";
	
	$requete = mysql_query($sql,$server_link);

	if ( mysql_num_rows($requete) > 0 && !isset($_GET['forcer']) ) {
		echo "<h3>Ce jeu a ".mysql_num_rows($requete)." prêts!</h3>";
		echo "<p>Vous devez changer le jeu de chacun de ces prêts pour pouvoir supprimer ce jeu.</p>";
		echo "<p>Ou alors cliquez sur <a href='../jeux/del.php?forcer=1&amp;id_jeu={$_GET['id_jeu']}'>forcer</a> : cela supprimera tous les prêts de ce jeu!</p>";
		echo "<table>";
		echo "<tr><th>Etat</th><th>JEU</th><th>ADHERENT</th><th>REGLERA</th></tr>";
		$ligne=FALSE;
		# affichage des résultats de la requête dans le menu déroulant
		while ($resultat = mysql_fetch_array($requete))
		{ 
	
			if ( $resultat['rendu'] ) $editer="Rendu";
			else $editer="Prêté jusqu'au ".$resultat['date_retour'];
	
			$ligne=alterne_tr($ligne);
			echo "<td>
			<a href=../pret/edit.php?id_pret=".$resultat['id_pret'].">$editer
			</a></td>
			<td><a href=../jeux/edit.php?id_jeu=".$resultat['id_jeu'].">".nom_jeu($resultat['id_jeu'])."</a></td>
			<td><a href=../jeux/edit.php?id_adherent=".$resultat['id_adherent'].">".nom_adherent($resultat['id_adherent'])."</a></td>
			<td>".$resultat['reglera']."</td>
			</tr>";
		} 
		echo "</table>";
	} else {
                $sql = "DELETE FROM prets WHERE id_jeu='".mysql_real_escape_string($_GET['id_jeu'],$server_link)."'";
		mysql_query($sql,$server_link);

		$sql="DELETE FROM jeu WHERE id_jeu='".mysql_real_escape_string($_GET['id_jeu'],$server_link)."'";
		mysql_query($sql,$server_link);
		echo '<P>Ce jeu a été définitivement supprimé!</P>';
	}
  	include "../fonctions/finpage.php"; 
?>
