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

	if (isset($_GET['jeu'])) $_POST['jeu']=$_GET['jeu'];
	include "entt.php";
	echo "<h1>RECHERCHE DE PRETS</h1>";
// construction de la recherche multi-critères
	$sql = "SELECT prets.id_pret,prets.rendu,prets.date_retour,
				prets.date_pret,prets.id_jeu,prets.id_adherent,
				prets.reglera,jeu.id_jeu,jeu.nom,
				adherent.id_adherent,adherent.nom,adherent.prenom  
			FROM prets,jeu,adherent
			WHERE prets.id_jeu=jeu.id_jeu
			AND adherent.id_adherent=prets.id_adherent "; 
	if (isset($_POST['jeu']) && $_POST['jeu'] != "")
		$sql .= " AND jeu.nom LIKE '%".$_POST['jeu']."%' ";
	if (isset($_POST['adherent']) && $_POST['adherent'] != "")
		$sql .= " AND ( adherent.nom LIKE '%".$_POST['adherent']."%'
			OR adherent.prenom LIKE '%".$_POST['adherent']."%' ) ";
	if (isset($_POST['date_pret']) && $_POST['date_pret'] != "")
		$sql.= " AND prets.date_pret LIKE '%".$_POST['date_pret']."%'";
	if (isset($_POST['date_retour']) && $_POST['date_retour'] != "")
		$sql.= " AND prets.date_retour LIKE '%".$_POST['date_retour']."%' ";
	if (isset($_POST['reglera']) && $_POST['reglera'] != "")
		$sql.= " AND prets.reglera LIKE '%".$_POST['reglera']."%' ";

	$sql .= " ORDER BY adherent.nom LIMIT 0,100 ";

	$requete = mysql_query($sql,$server_link);
	echo "<h3>".mysql_num_rows($requete)." réponses trouvées</h3>";

	echo "<form name=recherche_pret action=recherche.php method=post>
	<table>";
	echo "<tr><th>Etat</th>
		<th>Jeu<br><input name=jeu type=text SIZE=10
			MAXLENGTH=20 value='";
	if (isset($_POST['jeu'])) echo $_POST['jeu'];
	echo "'></th>
		<th>Adhèrent<br><input name=adherent type=text SIZE=10
			MAXLENGTH=10 value='";
	if (isset($_POST['adherent'])) echo $_POST['adherent'];
	echo "'></th><th>Date de prêt<br><input name=date_pret type=text SIZE=10
			MAXLENGTH=10 value=";
	if (isset($_POST['date_pret'])) echo $_POST['date_pret'];
	echo "></th>
		<th>Date retour<br><input name=date_retour type=text SIZE=10
			MAXLENGTH=10 value='";
	if (isset($_POST['date_retour'])) echo $_POST['date_retour'];
	echo "'></th>
		<th>Règlera<br><input name=reglera type=text SIZE=20
			MAXLENGTH=50 value='";
	if (isset($_POST['reglera'])) echo $_POST['reglera'];
	echo "'></th>
		<th><input type=submit value=RECHERCHER></th>
		</tr>";
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
		<td>".$resultat['date_pret']."</td>
		<td>".$resultat['date_retour']."</td>
		<td colspan=2>".$resultat['reglera']."</td>
		</tr>";
	} 
	echo "</table></form>";
  	include "../fonctions/finpage.php"; 
?>
