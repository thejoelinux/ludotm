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
$sql="SELECT date,enfant_m6,enfant_p6,mere,pere,ass_mat,autre
	FROM stats_jour ORDER BY date DESC LIMIT 0,30";
$requete=mysql_query($sql,$server_link);
echo "<h1>PRESENCE QUOTIDIENNE</h1>";
echo "<table>";
echo "<tr><th>DATE</th><th>Enfant -6</th><th>Enfant +6</th><th>Mère</th>
	<th>Père</th><th>Assistant Maternel</th><th>Autre</th></tr>";

while ($resultat = mysql_fetch_array($requete))
{
	echo "<tr>
		<td>".$resultat['date']."</td>
		<td>".$resultat['enfant_m6']."</td>
		<td>".$resultat['enfant_p6']."</td>
		<td>".$resultat['mere']."</td>
		<td>".$resultat['pere']."</td>
		<td>".$resultat['ass_mat']."</td>
		<td>".$resultat['autre']."</td>
		</tr>";
}
echo "</table>";
include "../fonctions/finpage.php";
