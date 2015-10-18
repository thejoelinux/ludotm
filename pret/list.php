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
	if (isset($_GET['retour']))
	{
		$sql.= " AND prets.rendu='0' ";
		echo "<h1>PRETS EN COURS</h1>";
	}
	elseif (isset($_GET['retards']))
	{
		$sql.= " AND prets.rendu='0' AND date_retour < curdate()";
		echo "<h1>PRETS EN RETARD</h1>";
	}
	else
	{
		$sql.= " AND prets.rendu='0'
			AND adherent.id_adherent='".$_GET['id_adherent']."'";
		echo "<h1>PRETS EN COURS DE L'ADHERENT</h1>";
	}
	$sql.=" ORDER BY adherent.nom ";
	$requete = mysql_query($sql,$server_link); 
	echo "<h3>".mysql_num_rows($requete)." réponses trouvées</h3>";
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
		<a href=edit.php?id_pret=".$resultat['id_pret'].">$editer
		</a></td>
		<td><a href=../jeux/edit.php?id_jeu=".$resultat['id_jeu'].">".nom_jeu($resultat['id_jeu'])."</a></td>
		<td><a href=../adherents/edit.php?id_adherent=".$resultat['id_adherent'].">".nom_adherent($resultat['id_adherent'])."</a></td>
		<td>".$resultat['reglera']."</td>
		</tr>";
	} 
	echo "</table";
  	include "../fonctions/finpage.php"; 
?>
