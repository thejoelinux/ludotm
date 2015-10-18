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

function ligne_encours()
{
	global $server_link;
	$sql="SELECT count(*) FROM jeu";
	$requete=mysql_query($sql,$server_link);
	$resultat = mysql_fetch_array($requete);
	echo "Jeux : ".$resultat[0]." - ";

	$sql="SELECT count(*) FROM adherent";
	$requete=mysql_query($sql,$server_link);
	$resultat = mysql_fetch_array($requete);
	echo "Adhérents : ".$resultat[0]." - ";

	$sql="SELECT count(*) FROM prets WHERE rendu=0";
	$requete=mysql_query($sql,$server_link);
	$resultat = mysql_fetch_array($requete);
	echo "Prêts en cours : ".$resultat[0];
}

	echo "<h1>STATISTIQUES DISPONIBLES</h1>";
	echo "<table>";
	echo "<tr>
		<th><a href=presence.php>Présence les derniers jours</a>
		</th></tr><tr>
		<th><a href=statsprets.php>Statistiques des Prêts sur une année</a>
		</th></tr><tr>
		<th><a href=statspres.php>Statistiques de Présence sur une année</a>
		</th></tr><tr>
		<th><a href=statspres2.php>Statistiques de Présence par âge sur une année</a>
		</th>
		</tr><tr>
		<th><a href=statsweek.php>Présence Moyenne par jour de la semaine</a>
		</th>
		</tr>
		<tr><td>";
	ligne_encours();
	echo "</td></tr></table>";
  	include "../fonctions/finpage.php"; 
