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

$sql = "SELECT * FROM jeu ORDER BY nom"; 
$requete = mysql_query($sql,$server_link); 

echo "<h1>LISTE DES JEUX</h1>";

echo "<table>";
echo "<tr><th>NOM</th></tr>";
$ligne=FALSE;
# affichage des résultats de la requête dans le menu déroulant
while ($resultat = mysql_fetch_array($requete))
{ 
	$ligne=alterne_tr($ligne);
	echo "<td><a href=edit.php?id_jeu=".$resultat['id_jeu'].
	">".$resultat['nom']."</a></td></tr>";
} 
echo "</table";
include "../fonctions/finpage.php"; 
?>
