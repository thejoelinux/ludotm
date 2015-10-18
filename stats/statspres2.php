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
echo "<h1>FRÉQUENTATION ANNUELLE DE LA LUDOTHÈQUE</h1>";
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
{
	echo "<h2>Par trimestre</h2>";
	// on veut les jours d'ouverture, les enfants et les adultes par mois
	stats_presence2('QUARTER',$_POST['year'],'Trimestre');
	echo "<h2>Par mois</h2>";
	echo '<img src=image_mois.php?year='.$_POST['year'].'>';
	// on veut les jours d'ouverture, les enfants et les adultes par mois
	stats_presence2('MONTH',$_POST['year'],'Mois');
	echo "<h2>Par an</h2>";
	// on veut les jours d'ouverture, les enfants et les adultes par mois
	stats_presence2('YEAR',$_POST['year'],'Année');
}
include "../fonctions/finpage.php";