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
echo "<h1>FRÉQUENTATION DE LA LUDOTHÈQUE</h1>";
echo "<h2>Moyenne par jour de la semaine</h2>";

echo "<form name=annee action=".$_SERVER['PHP_SELF']." method=post>
	Année <select name=year>";
for ($annee=2020;$annee>2004;$annee--)
{
	echo "<option ";
	if (isset($_POST['year']) && $_POST['year']==$annee) echo "selected";
	elseif ($annee==date('Y')) echo "selected";
	echo " value=$annee>$annee</option>";
}
echo "</select><input type=submit value=Calculer></form>";

if (isset($_POST['year']))


$sql="SELECT date AS jour,
		AVG(enfant_m6) + AVG(enfant_p6) AS enfants,
		AVG(mere) + AVG(pere) + AVG(ass_mat) + AVG(autre) AS adultes,
		count(*) as jours
	FROM stats_jour
	WHERE YEAR(date)={$_POST['year']}
	GROUP BY DAYOFWEEK(date)";
$requete=mysql_query($sql,$server_link);
echo "<table>";
echo "<tr><th>Jour de la semaine</th><th>Enfants</th>
	<th>Adultes</th><th>Jours d'ouverture</th></tr>";

$ligne=FALSE; // pour alterner les lignes
$total_enfants=$total_adultes=$total_jours=0;
while ($resultat = mysql_fetch_array($requete))
{
		$ligne=alterne_tr($ligne);
		echo "<td>".strftime("%A",strtotime($resultat['jour']))."</td>
			<td>".intval($resultat['enfants'])."</td>
			<td>".intval($resultat['adultes'])."</td>
			<td>".intval($resultat['jours'])."</td>
		</tr>";
}
echo "</table>";
include "../fonctions/finpage.php";