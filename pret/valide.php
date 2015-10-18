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
while (list ($key, $val) = each ($_POST)) {
       $_POST[$key] = mysql_real_escape_string($val);
   }

if (!$_POST[id_pret])
{	
	$sql = "insert into prets(
			id_jeu,
			id_adherent,
			date_pret,
			date_retour,
			rendu,
			reglera)
		values (
			'".$_POST[id_jeu]."',
			'".$_POST[id_adherent]."',
			'".$_POST[date_pret]."',
			'".$_POST[date_retour]."',
			'".$_POST[rendu]."',
			'".$_POST[reglera]."')";
	$res=sql_command($sql,$server_link);
}
else
{
	$sql="update `prets` set id_pret='".$_POST[id_pret]."',
		             id_jeu='".$_POST[id_jeu]."',
			     id_adherent='".$_POST[id_adherent]."',
			     date_pret='".$_POST[date_pret]."',
			     date_retour='".$_POST[date_retour]."',
			     rendu='".$_POST[rendu]."',
			     reglera='".$_POST[reglera]."' 
			     where id_pret='".$_POST[id_pret]."'";
	$res=sql_command($sql,$server_link);
	if ($_POST[prolonge])
	{	
		$sql = "insert into prets(
				id_jeu,
				id_adherent,
				date_pret,
				date_retour,
				rendu,
				reglera)
			values (
				'".$_POST[id_jeu]."',
				'".$_POST[id_adherent]."',
				DATE_ADD('".$_POST[date_pret]."', INTERVAL 1 MONTH),
				DATE_ADD('".$_POST[date_retour]."', INTERVAL 1 MONTH),
				'0',
				'".$_POST[reglera]."')";
		$res=sql_command($sql,$server_link);
		$jeu=get_jeu($_POST[id_jeu]);
		header("Location: ../pret/recherche.php?jeu=".$jeu['nom']);
		exit();
	}
}	
header("Location: ../accueil/index.php");
