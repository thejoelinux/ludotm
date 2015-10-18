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

if (!$_POST[id_jeu])
{	
	$sql = "insert into jeu(
			nom,
			reference,
			fabricant,
			categorie,
			categorie_esar_id,
			commentaire,
			infos_fabricant,
			inventaire,
			date_achat,
			prix,
            nombre_mini,
            nombre_maxi,
            age_mini,
            age_maxi,
            type
            )
		values (
			'".$_POST[nom]."',
			'".$_POST[reference]."',
			'".$_POST[fabricant]."',
			'".$_POST[categorie]."',
			'".$_POST[categorie_esar_id]."',
			'".$_POST[commentaire]."',
			'".$_POST[infos_fabricant]."',
			'".$_POST[inventaire]."',
			'".$_POST[date_achat]."',
			'".$_POST[prix]."',
            '".$_POST[nombre_mini]."',
            '".$_POST[nombre_maxi]."',
            '".$_POST[age_mini]."',
            '".$_POST[age_maxi]."',
            '".$_POST[type]."')";
}
else
{
	$sql="update `jeu` set id_jeu='".$_POST[id_jeu]."',
		         nom='".$_POST[nom]."',
			     reference='".$_POST[reference]."',
			     fabricant='".$_POST[fabricant]."',
			     categorie='".$_POST[categorie]."',
			     categorie_esar_id='".$_POST[categorie_esar_id]."',
			     commentaire='".$_POST[commentaire]."',
			     infos_fabricant='".$_POST[infos_fabricant]."',
			     inventaire='".$_POST[inventaire]."',
			     date_achat='".$_POST[date_achat]."',
			     prix='".$_POST[prix]."',
                 nombre_mini='".$_POST[nombre_mini]."',
                 nombre_maxi='".$_POST[nombre_maxi]."',
                 age_mini='".$_POST[age_mini]."',
                 age_maxi='".$_POST[age_maxi]."',
                 type='".$_POST[type]."' 
			     where id_jeu='".$_POST[id_jeu]."'";
}	
$res=sql_command($sql,$server_link);
header("Location: ../accueil/index.php");
