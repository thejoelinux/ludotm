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


$_POST['num_adherent'] = $_POST['num_adherent']+0;
if (!isset($_POST['newsletter'])) {
    $_POST['newsletter'] = 0;
}

while (list ($key, $val) = each ($_POST)) {
       $_POST[$key] = mysql_real_escape_string($val);
   }

if (!$_POST[id_adherent])
{	
	$sql = "insert into adherent(
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
            )
		values (
			'".$_POST[nom]."',
			'".$_POST[prenom]."',
			'".$_POST[date_inscription]."',
			'".$_POST[date_naissance]."',
			'".$_POST[adresse]."',
			'".$_POST[cp_ville]."',
			'".$_POST[tel_maison]."',
			'".$_POST[tel_travail]."',
			'".$_POST[tel_mobile]."',
			'".$_POST[tel_fax]."',
			'".$_POST[commentaire]."',
			'".$_POST[num_adherent]."',
			'".$_POST[adhesion]."',
			'".$_POST[email]."',
			'".$_POST[newsletter]."',
			'".$_POST[autres]."',
			'".$_POST[caution]."')";
}
else
{
	$sql="update `adherent` set id_adherent='".$_POST[id_adherent]."',
		         nom='".$_POST[nom]."',
			     prenom='".$_POST[prenom]."',
			     date_inscription='".$_POST[date_inscription]."',
			     date_naissance='".$_POST[date_naissance]."',
			     adresse='".$_POST[adresse]."',
			     cp_ville='".$_POST[cp_ville]."',
			     tel_maison='".$_POST[tel_maison]."',
			     tel_travail='".$_POST[tel_travail]."',
			     tel_mobile='".$_POST[tel_mobile]."',
			     tel_fax='".$_POST[tel_fax]."',
			     commentaire='".$_POST[commentaire]."', 
			     num_adherent='".$_POST[num_adherent]."', 
			     adhesion='".$_POST[adhesion]."', 
			     email='".$_POST[email]."', 
			     newsletter='".$_POST[newsletter]."', 
			     autres='".$_POST[autres]."', 
			     caution='".$_POST[caution]."' 
			     where id_adherent='".$_POST[id_adherent]."'";
}	
$res=sql_command($sql,$server_link);
header("Location: ../accueil/index.php");
