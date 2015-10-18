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
			prets.id_adherent,prets.reglera,
			adherent.id_adherent,adherent.nom,adherent.prenom
			FROM prets,adherent
			WHERE adherent.id_adherent=prets.id_adherent "; 
	$sql.= " AND adherent.id_adherent='".mysql_real_escape_string($_GET['id_adherent'],$server_link)."'";
		echo "<h1>PRETS DE L'ADHERENT</h1>";
	
	$requete = mysql_query($sql,$server_link);

	if ( mysql_num_rows($requete) > 0 && !isset($_GET['forcer']) ) {
		echo "<h3>Cet adhérent a ".mysql_num_rows($requete)." prêts!</h3>";
		echo "<p>Vous devez changer l'adhérent de chacun de ces prêts pour pouvoir supprimer cet adhérent.</p>";
		echo "<p>Ou alors cliquez sur <a href='../adherents/del.php?forcer=1&amp;id_adherent={$_GET['id_adherent']}'>forcer</a> : cela supprimera tous les prêts de cet adhérent!</p>";
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
			<td><a href=../adherents/edit.php?id_adherent=".$resultat['id_adherent'].">".nom_adherent($resultat['id_adherent'])."</a></td>
			<td>".$resultat['reglera']."</td>
			</tr>";
		} 
		echo "</table>";
	} else {
                $sql = "DELETE FROM prets WHERE id_adherent='".mysql_real_escape_string($_GET['id_adherent'],$server_link)."'";
		mysql_query($sql,$server_link);

		$sql="DELETE FROM adherent WHERE id_adherent='".mysql_real_escape_string($_GET['id_adherent'],$server_link)."'";
		mysql_query($sql,$server_link);
		echo '<P>Cet adhérent a été définitivement supprimé!</P>';
	}
  	include "../fonctions/finpage.php"; 
?>
