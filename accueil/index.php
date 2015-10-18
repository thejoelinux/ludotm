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

	include "../fonctions/enttappli.php";

//récupération des valeurs statistiques en cours
$sql="SELECT date,enfant_m6,enfant_p6,mere,pere,ass_mat,autre
		FROM stats_jour
		WHERE date='".date('Y-m-d')."'";
$res=mysql_query($sql,$server_link);
if (sql_count($res)) $stat=mysql_fetch_array($res);
else $stat=array('date','enfant_m6'=>0,'enfant_p6'=>0,'mere'=>0,'pere'=>0,'ass_mat'=>0,'autre'=>0);

?>
<div class="corps"><h2>ACCUEIL</h2><h3>Cliquer sur une action</h3>
	<table width="100%">
		<tr>
			<td align=center><a href=../pret/edit.php>
			 <img src=../images/pret.png><BR>PRETER UN JEU</a>
			</td>
			<td align=center>&nbsp;
			</td>
			<td align=center><a href=../pret/list.php?retour=1>
			 <img src=../images/retour.png><BR>RENDRE UN JEU</a>
			</td>
		</tr>
		<tr>
			<td align=center>&nbsp;
			</td>
			<td align=center>
			<img src="../images/tous.png"/><br/>
            <a href=../pret/recherche.php>RECHERCHER DES PRETS</a><br/>
            <a href="../jeux/recherche.php">RECHERCHER DES JEUX</a>

			</td>
			<td align=center><a href=../pret/list.php?retards=1>
			 <BR>PRETS EN RETARD</a>
			</td>
		</tr>
		<tr>
			<td align=center><a href=../adherents/edit.php>AJOUTER UN ADHERENT</a>
			</td>
			<td align=center>&nbsp;
			</td>
			<td align=center><a href=../adherents/list.php>LISTE DES ADHERENTS</a>
			</td>
		</tr>
		<tr>
			<td align=center><a href=../jeux/edit.php>AJOUTER UN JEU</a>
			</td>
			<td align=center>&nbsp;
			</td>
			<td align=center><a href=../jeux/list.php>LISTE DES JEUX</a>
			</td>
		</tr>
	</table>
	<a href=../stats/list.php>Statistiques</a>
	<table width="100%" border=1>
		<tr>
			<td align=center>
				<a href="../stats/incremente.php?qui=enfant_m6">Enfant -6</a>
			</td>
			<td align=center>
				<a href="../stats/incremente.php?qui=enfant_p6">Enfant +6</a>
			</td>
			<td align=center>
				<a href="../stats/incremente.php?qui=mere">Mère</a>
			</td>
			<td align=center>
				<a href="../stats/incremente.php?qui=pere">Père</a>
			</td>
			<td align=center>
				<a href="../stats/incremente.php?qui=ass_mat">Assistant Maternel</a>
			</td>
			<td align=center>
				<a href="../stats/incremente.php?qui=autre">Autre</a>
			</td>
		</tr>
		<tr>
			<td align=center><?php echo $stat['enfant_m6'];?></td>
			<td align=center><?php echo $stat['enfant_p6'];?></td>
			<td align=center><?php echo $stat['mere'];?></td>
			<td align=center><?php echo $stat['pere'];?></td>
			<td align=center><?php echo $stat['ass_mat'];?></td>
			<td align=center><?php echo $stat['autre'];?></td>
		</tr>
	</table>
</div>
