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

$sql = "SELECT jeu.id_jeu, nom, CONCAT (categorie_esar.label, ' - ', categorie_esar.name) AS label,
	id_pret as etat_pret
	FROM jeu
	left outer join categorie_esar on jeu.categorie_esar_id = categorie_esar.id
	left outer join prets on (jeu.id_jeu = prets.id_jeu AND date_retour > curdate())
	ORDER BY nom"; 
$requete = mysql_query($sql,$server_link); 

?>
<h1>Liste des jeux</h1>

<table id="list_jeu">
	<thead>
		<tr>
		<th>Nom</th>
		<th>ESAR</th>
		<th>Etat</th>
		</tr>
	</thead>
	<tbody>
<?php
$ligne=FALSE;
# affichage des résultats de la requête dans le menu déroulant
while ($resultat = mysql_fetch_array($requete)) { ?>
	<tr>
		<td>
			<a href="edit.php?id_jeu=<?=$resultat['id_jeu']?>"><?=$resultat['nom']?></a>
		</td>
		<td>
			<?=$resultat['label']?>
		</td>
		<td>
			<?=($resultat['etat_pret'] == '') ? "Libre" : "Emprunte"?>
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {$('#list_jeu').DataTable()});
</script>
<?php
include "../fonctions/finpage.php"; 
?>
