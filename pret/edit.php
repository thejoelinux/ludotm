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
	if(document.forms["saisie"].id_adherent.value == 0)
	{
		alert ("Vous n'avez pas saisi l'emprunteur!");
		return false;
	}
	if(document.forms["saisie"].date_pret.value == 0)
	{
		alert ("Vous n'avez pas saisi la date de pret!");
		return false;
	}
	if(document.forms["saisie"].id_jeu.value == 0)
	{
		alert ("Vous n'avez pas saisi le jeu prêté!");
		return false;
	}
	document.forms["saisie"].submit();
	return true;
}
</SCRIPT>

<?php
	echo "<center>";
	if (isset($_GET['id_pret']))
	{
		$pret = get_pret($_GET['id_pret']);
		echo "<h3>PRET n°".$pret['id_pret']."</h3>";
	}
	else 
	#Création à vide
	{
		$pret = array('id_jeu'=>'',
			'id_adherent'=>'',
			'date_pret'=>date("Y-m-d"),
			'date_retour'=>date("Y-m-d",mktime(0, 0, 0, date("m")+1, date("d"), date("Y"))),
			'rendu'=>'',
			'reglera'=>'');
		echo "<h3>NOUVEAU PRET</h3>";
	}
?>

<table>
<form name="saisie" action="valide.php" enctype="multipart/form-data" method="post">
	<tr>
		<td align=right>Jeu</td>
		<td align=left><?php select_jeu($pret['id_jeu']);?></td>
	</tr>	
	<tr>
		<td align=right>Adhérent</td>
		<td align=left><?php select_adherent($pret['id_adherent'],1);?></td>
	</tr>	
	<tr>
		<td align=right>Date de prêt</td>
		<td align=left><input type=text name=date_pret SIZE=10 MAXLENGTH=10 
			value="<?php echo $pret['date_pret'];?>">
			<font size=-1> (AAAA-MM-JJ) Année-Mois-Jour</font></td>
	</tr>	
	<tr>
		<td align=right>Date de retour</td>
		<td align=left><input type=text name=date_retour SIZE=10 MAXLENGTH=10 
			value="<?php echo $pret['date_retour'];?>">
			<font size=-1>  (AAAA-MM-JJ) Année-Mois-Jour</font></td>
	</tr>	
	<tr>
		<td align=right>Rendu<input type=CHECKBOX name=rendu value="1"
			<?php if ($pret['rendu']) echo checked;?> ></td>
		<td align=right>Prêt prolongé <input type=CHECKBOX name=prolonge value="1">
		</td>
	</tr>	
	<tr>
		<td align=right>Règlera</td>
		<td align=left><input type=text name=reglera SIZE=60 MAXLENGTH=60 
			value="<?php echo $pret['reglera'];?>">
<?php if (isset($pret['id_pret'])) echo "<input type=hidden name=id_pret value=".$pret['id_pret'].">";?>
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

