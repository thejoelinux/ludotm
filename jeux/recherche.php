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
	
echo "<h1>RECHERCHE DE JEUX</h1>";
    
echo '<form method="post" action="">';
echo 'Age <input type="text" name="age" size=3 maxlength="3"/> ';
echo 'Nombre de joueurs <input type="text" name="nombre" size=3 maxlength="3"/> ';
echo 'Nom du jeu <input type="text" name="nom" size=20 maxlength="20"/> ';
echo 'Type de jeu <input type="text" name="type" size=20 maxlenth="20"/> ';
echo '<input type="submit"/>';
echo '</form>';
$condition = array();
if (isset($_POST['age']) && $_POST['age'] != '') {
    $condition[] = "age_mini<=" . $_POST['age']. " AND age_maxi>=" . $_POST['age'];
}
if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
    $condition[] = "nombre_mini<=" . $_POST['nombre'] . " AND nombre_maxi>=" . $_POST['nombre'];
}
if (isset($_POST['nom']) && $_POST['nom'] != '') {
    $condition[] = "nom like ('%" . $_POST['nom'] . "%')";
}
if (isset($_POST['type']) && $_POST['type'] != '') {
    $condition[] = "type like ('%" . $_POST['type'] . "%')";
}
if (count($condition) > 0) {
    $sql = "SELECT * FROM jeu WHERE " . implode(' AND ', $condition) . " ORDER BY nom"; 
    $requete = mysql_query($sql,$server_link); 
    if (mysql_num_rows($requete) > 0) {
        echo "<table>";
        echo "<tr><th>NOM</th></tr>";
        $ligne=FALSE;
        while ($resultat = mysql_fetch_array($requete)) { 
            $ligne=alterne_tr($ligne);
            echo "<td><a href=edit.php?id_jeu=".$resultat['id_jeu'].
                ">".$resultat['nom']."</a></td></tr>";
        } 
        echo "</table";
    }
}
include "../fonctions/finpage.php"; 
?>
