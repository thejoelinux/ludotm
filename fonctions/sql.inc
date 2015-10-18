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
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

require "database.php";
include "divers.inc";

setlocale(LC_TIME, "fr_FR.UTF-8");

function sql_query ($sql)
{
	$r = mysql_query($sql);
	return $r;
}

/** connexion_base()
 * 
 * Cette fonction permet de se connecter à la base de données
 */

function connexion_base()
{
	global $db_host,$db_database,$db_user,$db_user_password;

	$server_link = mysql_connect ($db_host,$db_user,$db_user_password) or die (mysql_error());
	$db_attempt = mysql_select_db ($db_database, $server_link) or die (mysql_error());
	#echo "Connected to database $database OK<br><br>\n";

	return $server_link;
}
$server_link=connexion_base();	

function sql_count ($r)
{
	return mysql_num_rows($r);
}

function sql_row ($r, $i)
{
	if ($i >= mysql_num_rows($r))
	{
		mysql_free_result($r);
		return 0;
	}
	mysql_data_seek($r, $i);
	return mysql_fetch_row($r);
}

function sql_command ($sql, $server_link)
{
	mysql_query($sql,$server_link) or die (mysql_error());
	
}

function get_adherent($id_adherent)
{
	global $server_link;
	$sql = "select	id_adherent,
			nom,
			prenom,
			date_inscription,
			date_naissance,
			adresse,
			cp_ville,
			tel_maison,
			tel_travail,
			tel_mobile,
			tel_fax,
			commentaire,
            num_adherent,
            adhesion,
            email,
            newsletter,
            autres,
            caution
		from adherent where id_adherent='".mysql_real_escape_string($id_adherent,$server_link)."'";
	$req = mysql_query($sql,$server_link);
	if(sql_count($req))
		return mysql_fetch_array($req);
	else
		return 0;
}

function get_jeu($id_jeu)
{
	global $server_link;
	$sql = "select	id_jeu,
			nom,
			reference,
			fabricant,
			categorie,
			categorie_esar_id,
			commentaire,
			infos_fabricant,
			inventaire,
			date_achat,
			prix,
            nombre_mini,
            nombre_maxi,
            age_mini,
            age_maxi,
            type
		from jeu where id_jeu=".mysql_real_escape_string($id_jeu,$server_link);
	$req = mysql_query($sql,$server_link);
	if(sql_count($req))
		return mysql_fetch_array($req);
	else
		return 0;
}

function est_prete($id_jeu) {
    global $server_link;
    $sql = "select * from prets where rendu=0 AND id_jeu=" . $id_jeu;
    $req = mysql_query($sql,$server_link);
    if(sql_count($req)==0)
        return false;
    else
        return true;
}

function get_pret($id_pret)
{
	global $server_link;
	$sql = "select	id_pret,
			id_jeu,
			id_adherent,
			date_pret,
			date_retour,
			rendu,
			reglera
		from prets where id_pret=".mysql_real_escape_string($id_pret,$server_link);
	$req = mysql_query($sql,$server_link);
	if(sql_count($req))
		return mysql_fetch_array($req);
	else
		return 0;
}

// Crée un select des adherents
function select_adherent($id_adherent,$date=0)
{
  global $server_link;
  echo "<select name='id_adherent'>\n"; 	
  echo "<option value='0'>Choix d'un adhérent</option>\n"; 
  $sql = "SELECT id_adherent,nom,prenom,date_inscription FROM adherent ORDER BY nom"; 
  $requete = mysql_query($sql,$server_link); 
  while ($res = mysql_fetch_array($requete)) {
    $date ? $d=adhesion_a_jour($res['date_inscription']) : $d='';
    $d=='' ? $c='good' : $c='old';
    $id_adherent==$res['id_adherent'] ? $s=' selected' : $s='';
    echo "<option class=$c value='".$res["id_adherent"]."'$s>".
            $res["nom"]." ".$res["prenom"]."$d</option>\n"; 
  } 
  echo "</select>\n"; 
}

// select on categorie esar
function select_categorie_esar($categorie_esar_id) {
  global $server_link;
  echo "<select name='categorie_esar_id'>\n"; 	
  echo "<option value='0' ".($categorie_esar_id == 0 ? "SELECTED" : "").">Choisissez la categorie</option>\n"; 
  $sql = "SELECT id, CONCAT(label, ' - ', name) AS description FROM categorie_esar ORDER BY label"; 
  $requete = mysql_query($sql,$server_link); 
  while ($res = mysql_fetch_array($requete)) {
    $s = ($categorie_esar_id == $res['id']) ? 'selected' : '';
    echo "<option value='".$res["id"]."' $s>".
      $res["description"]."</option>\n"; 
  } 
  echo "</select>\n"; 

}

// Crée un select des jeux
function select_jeu($id_jeu)
{
	global $server_link;
	echo "<select name='id_jeu'>\n"; 	
	echo "<option value='0'>Choix d'un jeu</option>\n"; 
	$sql = "SELECT id_jeu,nom FROM jeu ORDER BY nom"; 
	$requete = mysql_query($sql,$server_link); 
	while ($resultat = mysql_fetch_array($requete)) 
	{ 
		if($id_jeu==$resultat["id_jeu"])
			$selecte=" selected";
		else
			$selecte="";
		echo "<option value='".$resultat["id_jeu"]."'$selecte>".
			$resultat["nom"]."</option>\n"; 
	} 
	echo "</select>\n"; 
}

function nom_adherent($id_adherent)
{
	$adherent = get_adherent($id_adherent);
	return $adherent['nom']." ".$adherent['prenom'];
}

function nom_jeu($id_jeu)
{
	$jeu = get_jeu($id_jeu);
	return $jeu['nom'];
}

// on veut les jours d'ouverture, les enfants et les adultes
// par $intervale pour la $periode
function stats_presence($intervale,$periode,$intervale_fr)
{
	global $server_link;
	$sql="SELECT date AS intervale,
			SUM(enfant_m6 + enfant_p6) AS enfants,
			SUM(mere + pere + ass_mat + autre) AS adultes,
			COUNT(*) AS jours
		FROM stats_jour WHERE YEAR(date)=".mysql_real_escape_string($periode,$server_link)." 
		GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date)";
	$requete=mysql_query($sql,$server_link);
	echo "<table>";
	echo "<tr><th>$intervale_fr</th><th>Enfants</th>
		<th>Adultes</th><th>Nombre de jours d'ouverture</th></tr>";
	
	$ligne=FALSE; // pour alterner les lignes
	$total_enfants=$total_adultes=$total_jours=0;
	$trimestre=0;
	while ($resultat = mysql_fetch_array($requete))
	{
			$ligne=alterne_tr($ligne);
			echo "<td>";
			if(!strcmp($intervale,'MONTH'))
			echo strftime("%B",strtotime($resultat['intervale']));
			elseif(!strcmp($intervale,'YEAR'))
			echo strftime("%Y",strtotime($resultat['intervale']));
			else {$trimestre++;echo $trimestre;}
	
			echo "</td>
				<td>".$resultat['enfants']."</td>
				<td>".$resultat['adultes']."</td>
				<td>".$resultat['jours']."</td>
			</tr>";
			$total_enfants+=$resultat['enfants'];
			$total_adultes+=$resultat['adultes'];
			$total_jours+=$resultat['jours'];
	}
	echo "</table>";
	if ( !strcmp($intervale,'YEAR'))
	echo "<BR>Moyenne sur l'année : ".
		round($total_enfants/$total_jours)." enfants/jour et ".
		round($total_adultes/$total_jours)." adultes/jour.";
}

// on veut les jours d'ouverture, les enfants -6 et +6 et les adultes
// par $intervale pour la $periode
function stats_presence2($intervale,$periode,$intervale_fr)
{
	global $server_link;
	$sql="SELECT date AS intervale,
			SUM(enfant_m6) AS enfant_m6,
			SUM(enfant_p6) AS enfant_p6,
			SUM(mere + pere + ass_mat + autre) AS adultes,
			COUNT(*) AS jours
		FROM stats_jour WHERE YEAR(date)=".mysql_real_escape_string($periode ,$server_link)."
		GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date)";
	$requete=mysql_query($sql,$server_link);
	echo "<table>";
	echo "<tr><th>$intervale_fr</th><th>Enfants -6</th><th>Enfants +6</th>
		<th>Adultes</th><th>Nombre de jours d'ouverture</th></tr>";
	
	$ligne=FALSE; // pour alterner les lignes
	$total_enfants=$total_adultes=$total_jours=0;
	$trimestre=0;
	while ($resultat = mysql_fetch_array($requete))
	{
			$ligne=alterne_tr($ligne);
			echo "<td>";
			if(!strcmp($intervale,'MONTH'))
			echo strftime("%B",strtotime($resultat['intervale']));
			elseif(!strcmp($intervale,'YEAR'))
			echo strftime("%Y",strtotime($resultat['intervale']));
			else {$trimestre++;echo $trimestre;}
	
			echo "</td>
				<td>".$resultat['enfant_m6']."</td>
				<td>".$resultat['enfant_p6']."</td>
				<td>".$resultat['adultes']."</td>
				<td>".$resultat['jours']."</td>
			</tr>";
			$total_enfant_m6+=$resultat['enfant_m6'];
			$total_enfant_p6+=$resultat['enfant_p6'];
			$total_adultes+=$resultat['adultes'];
			$total_jours+=$resultat['jours'];
	}
	echo "</table>";
	if ( !strcmp($intervale,'YEAR'))
	echo "<BR>Moyenne sur l'année : ".
		round($total_enfant_m6/$total_jours)." enfants -6 ans/jour et ".
		round($total_enfant_p6/$total_jours)." enfants +6 ans/jour et ".
		round($total_adultes/$total_jours)." adultes/jour.";
}

// on veut les prêts
// par $intervale pour la $periode
function stats_prets($intervale,$periode,$intervale_fr)
{
	global $server_link;
	$sql="SELECT date_pret AS intervale,
			count(*) AS prets
		FROM prets WHERE YEAR(date_pret)=".mysql_real_escape_string($periode ,$server_link)." 
		GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date_pret)";
	$requete=mysql_query($sql,$server_link);
	echo "<table>";
	echo "<tr><th>$intervale_fr</th><th>Prêts</th></tr>";
	
	$ligne=FALSE; // pour alterner les lignes
	$trimestre=0;
	$total_prets=0;
	while ($resultat = mysql_fetch_array($requete))
	{
			$ligne=alterne_tr($ligne);
			echo "<td>";
			if(!strcmp($intervale,'MONTH'))
			echo strftime("%B",strtotime($resultat['intervale']));
			elseif(!strcmp($intervale,'YEAR'))
			echo strftime("%Y",strtotime($resultat['intervale']));
			else {$trimestre++;echo $trimestre;}
	
			echo "</td>
				<td>".$resultat['prets']."</td>
			</tr>";
			$total_prets+=$resultat['prets'];
	}
	echo "</table>";
}
