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
?>

<SCRIPT LANGUAGE="JavaScript">
function validate_and_submit ()
{
	if(document.forms["saisie"].nom.value == 0)
	{
		alert ("Vous n'avez pas saisi le nom!");
		return false;
	}
	document.forms["saisie"].submit();
	return true;
}
</SCRIPT>

<?php
	echo "<center>";
	if (isset($_GET['id_jeu']))
	{
		$jeu = get_jeu($_GET['id_jeu']);
		echo "<h3>JEU n°".$_GET['id_jeu'];
        if (est_prete($_GET['id_jeu'])) {
            echo "(INDISPONIBLE)</h3>";
        } else {
            echo "(DISPONIBLE)</h3>";
        }
		echo "<a href='../pret/recherche.php?jeu=".$jeu['nom']."'>
			Historique des prêts</a>";
	}
	else 
	#Création à vide
	{
		$jeu = array('nom'=>'','reference'=>'','fabricant'=>'','infos_fabricant'=>'','categorie'=>'',
			'categorie_esar_id' => 0,
			'prix'=>'','date_achat'=>date("Y-m-d"),'inventaire'=>'','commentaire'=>'');
		echo "<h3>NOUVEAU JEU</h3>";
	}
?>

<table>
<form name="saisie" action="valide.php" enctype="multipart/form-data" method="post">
	<tr>
		<td align=right>Nom</td>
		<td align=left><input type=text name=nom SIZE=50 MAXLENGTH=50 
			value="<?php echo $jeu['nom'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Référence</td>
		<td align=left><input type=text name=reference SIZE=20 MAXLENGTH=20 
			value="<?php echo $jeu['reference'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Fabricant</td>
		<td align=left><input type=text name=fabricant SIZE=20 MAXLENGTH=20 
			value="<?php echo $jeu['fabricant'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Informations du Fabricant</td>
		<td align=left><input type=text name=infos_fabricant SIZE=60 MAXLENGTH=60 
			value="<?php echo $jeu['infos_fabricant'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Catégorie</td>
		<td align=left><input type=text name=categorie SIZE=40 MAXLENGTH=40 
			value="<?php echo $jeu['categorie'];?>">
		(ex sy as rè)
		</td>
	</tr>	
	<tr>
		<td align=right>Catégorie ESAR</td>
		<td align="left">
			<?php select_categorie_esar($jeu['categorie_esar_id']);?>	
		</td>
	</tr>
	<tr>
		<td align=right>Prix</td>
		<td align=left><input type=text name=prix SIZE=3 MAXLENGTH=3 
			value="<?php echo $jeu['prix'];?>">
		</td>
	</tr>	
	<tr>
		<td align=right>Nombre de joueurs</td>
		<td align=left>Mini -><input type=text name=nombre_mini SIZE=3 MAXLENGTH=3 
			value="<?php echo $jeu['nombre_mini'];?>">
		    Maxi -><input type=text name=nombre_maxi SIZE=3 MAXLENGTH=3 
			value="<?php echo $jeu['nombre_maxi'];?>">
		</td>
	</tr>	
	<tr>
		<td align=right>Age des joueurs</td>
		<td align=left>Mini -><input type=text name=age_mini SIZE=3 MAXLENGTH=3 
			value="<?php echo $jeu['age_mini'];?>">
		    Maxi -><input type=text name=age_maxi SIZE=3 MAXLENGTH=3 
			value="<?php echo $jeu['age_maxi'];?>">
		</td>
	</tr>	
	<tr>
		<td align=right>Type de jeu</td>
		<td align=left><input type=text name=type SIZE=40 MAXLENGTH=40 
			value="<?php echo $jeu['type'];?>">
		</td>
	</tr>	
	<tr>
		<td align=right>Date d'acquisition</td>
		<td align=left><input type=text name=date_achat SIZE=10 MAXLENGTH=10 
			value="<?php echo $jeu['date_achat'];?>">
			<font size=-1> (AAAA-MM-JJ) Année-Mois-Jour</font></td>
	</tr>	
	<tr>
		<td align=right>Inventaire</td>
		<td align=left><textarea name=inventaire cols=60 rows=7><?php echo $jeu['inventaire'];?></textarea></td>
	</tr>
	<tr>
		<td align=right>Commentaire</td>
		<td align=left><textarea name=commentaire cols=60 rows=5><?php echo $jeu['commentaire'];?></textarea>
<?php if (isset($jeu['id_jeu'])) { ?>
	<tr>
                <input type="hidden" name="id_jeu" value="<?=$jeu['id_jeu']?>">
		<td colspan="2"><a href="del.php?id_jeu=<?=$jeu['id_jeu']?>">SUPPRIMER</a></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="2" align="center">
			<input type="button" value="VALIDER" onClick="validate_and_submit()">
		</td>
	</tr>	

</form>
</table>
<?php 
include "../fonctions/finpage.php";
?>

