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
	if(document.forms["saisie"].date_inscription.value == 0)
	{
		alert ("Vous n'avez pas saisi la date d'inscription!");
		return false;
	}
	if(document.forms["saisie"].date_naissance.value == 0)
	{
		alert ("Vous n'avez pas saisi la date de naissance!");
		return false;
	}
	document.forms["saisie"].submit();
	return true;
}
</SCRIPT>

<?php
	echo "<center>";
	if (isset($_GET['id_adherent']))
	{
		$adherent = get_adherent($_GET['id_adherent']);
		echo "<h3>ADHERENT n°".$_GET['id_adherent']."</h3>";
		echo "<a href='../pret/list.php?id_adherent=".$_GET['id_adherent']."'>
			PRETS EN COURS DE l'ADHERENT</a>";
	}
	else 
	#Création à vide
	{
		$adherent = array('nom'=>'','prenom'=>'','date_inscription'=>'','date_naissance'=>'','adresse'=>'','cp_ville'=>'','tel_maison'=>'','tel_travail'=>'','tel_mobile'=>'','tel_fax'=>'','commentaire'=>'');
		echo "<h3>NOUVEL ADHERENT</h3>";
	}
?>

<table>
<form name="saisie" action="valide.php" enctype="multipart/form-data" method="post">
	<tr>
		<td align=right>Num&eacute;ro</td>
		<td align=left><input type=text name=num_adherent SIZE=4 MAXLENGTH=4 
			value="<?php if ($adherent['num_adherent']>0) { printf('%04d', $adherent['num_adherent']);}?>"></td>
	</tr>	
	<tr>
		<td align=right>Adh&eacute;sion</td>
        <?php $list_adhesion= array('Famille', 'Individuel', 'Nounou', 'Nounou+famille', 'Structure'); ?>
		<td align=left><select name="adhesion">
        <?php
            foreach ($list_adhesion as $cur) {
                if ($adherent['adhesion'] == $cur) {
                    echo '<option selected value="' . $cur . '">' . $cur . '</option>';
                } else {
                    echo '<option value="' . $cur . '">' . $cur . '</option>';
                }
            }
        ?>
        </select></td>
	</tr>	
	<tr>
		<td align=right>Caution</td>
        <?php $list_caution= array('Cheque', 'Espece', 'Aucune'); ?>
		<td align=left><select name="caution">
        <?php
            foreach ($list_caution as $cur) {
                if ($adherent['caution'] == $cur) {
                    echo '<option selected value="' . $cur . '">' . $cur . '</option>';
                } else {
                    echo '<option value="' . $cur . '">' . $cur . '</option>';
                }
            }
        ?>
        </select></td>
	</tr>	
	<tr>
		<td align=right>Nom</td>
		<td align=left><input type=text name=nom SIZE=50 MAXLENGTH=50 
			value="<?php echo $adherent['nom'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Prénom</td>
		<td align=left><input type=text name=prenom SIZE=50 MAXLENGTH=50 
			value="<?php echo $adherent['prenom'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Date inscription</td>
		<td align=left><input type=text name=date_inscription SIZE=10 MAXLENGTH=10 
			value="<?php echo $adherent['date_inscription'];?>">
			<font size=-1> (AAAA-MM-JJ) Année-Mois-Jour</font></td>
	</tr>	
	<tr>
		<td align=right>Date de naissance</td>
		<td align=left><input type=text name=date_naissance SIZE=10 MAXLENGTH=10 
			value="<?php echo $adherent['date_naissance'];?>">
			<font size=-1>  (AAAA-MM-JJ) Année-Mois-Jour</font></td>
	</tr>	
	<tr>
		<td align=right>Adresse</td>
		<td align=left><input type=text name=adresse SIZE=70 MAXLENGTH=70 
			value="<?php echo $adherent['adresse'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Code Postal et Ville</td>
		<td align=left><input type=text name=cp_ville SIZE=60 MAXLENGTH=60 
			value="<?php echo $adherent['cp_ville'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Tél. Domicile</td>
		<td align=left><input type=text name=tel_maison SIZE=14 MAXLENGTH=14 
			value="<?php echo $adherent['tel_maison'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Tél. Professionnel</td>
		<td align=left><input type=text name=tel_travail SIZE=14 MAXLENGTH=14 
			value="<?php echo $adherent['tel_travail'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Tél. Mobile</td>
		<td align=left><input type=text name=tel_mobile SIZE=14 MAXLENGTH=14 
			value="<?php echo $adherent['tel_mobile'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Tél. Fax</td>
		<td align=left><input type=text name=tel_fax SIZE=14 MAXLENGTH=14 
			value="<?php echo $adherent['tel_fax'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Email</td>
		<td align=left><input type=text name=email SIZE=50 MAXLENGTH=50 
			value="<?php echo $adherent['email'];?>"></td>
	</tr>	
	<tr>
		<td align=right>Newsletter</td>
		<td align=left>
        <?php
            if ($adherent['newsletter'] == 1) {
                echo '<input type="checkbox" name="newsletter" value="1" checked="checked"/>';
            } else {
                echo '<input type="checkbox" name="newsletter" value="1"/>';
            }?>
        </td>
	</tr>	
	<tr>
		<td align=right>Autres personnes rattach&eacute;es</td>
		<td align=left><textarea name=autres cols=60 rows=5><?php echo $adherent['autres'];?></textarea>
		</td>
	</tr>	
	<tr>
		<td align=right>Commentaire</td>
		<td align=left><textarea name=commentaire cols=60 rows=5><?php echo $adherent['commentaire'];?></textarea>
<?php if (isset($adherent['id_adherent'])) echo "
	<tr>
          <td colspan=2>
          <input type=hidden name=id_adherent value={$adherent['id_adherent']}>
            <!--a href='del.php?id_adherent={$adherent['id_adherent']}>'>SUPPRIMER</a-->
          </td>
	</tr>	
";?>
		</td>
	</tr>	
	<tr>
		<TD colspan=2 align=center>
			<SCRIPT LANGUAGE="JavaScript">
			document.writeln ( '<br><INPUT TYPE=button VALUE=VALIDER ONCLICK=validate_and_submit()>' );
			</SCRIPT>
		</TD>
	</tr>	

</form>
</table>
<?php 
include "../fonctions/finpage.php";
?>

