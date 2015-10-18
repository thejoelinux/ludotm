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

include "../fonctions/sql.inc";
//création de l'enregistrement du jour s'il n'existe pas
$sql="SELECT date,enfant_m6,enfant_p6,mere,pere,ass_mat,autre
	FROM stats_jour
	WHERE date='".date('Y-m-d')."'";
$res=mysql_query($sql,$server_link);
if ( !sql_count($res) )
{
	$sql_ins="INSERT INTO stats_jour(date) VALUES ('".date('Y-m-d')."')";
	$res_ins=sql_command($sql_ins,$server_link);
}

//récupération des valeurs en cours
$sql="SELECT date,enfant_m6,enfant_p6,mere,pere,ass_mat,autre
	FROM stats_jour
	WHERE date='".date('Y-m-d')."'";
$res=mysql_query($sql,$server_link);
$stat=mysql_fetch_array($res);

//incrementation des statistiques si appel correct de la page
if ($_GET['qui'])
{
	$stat[$_GET['qui']]=$stat[$_GET['qui']]+1;
	$set=" ".$_GET['qui']."=".$stat[$_GET['qui']];
	$sql="UPDATE stats_jour SET $set where date='".date('Y-m-d')."'";	
	$res=sql_command($sql,$server_link);
}
header("Location: ../accueil/index.php");
?>