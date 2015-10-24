<?php
// SQL SELECT jeu categorie_esar prets
$sql = "SELECT jeu.id_jeu, nom, 
		CONCAT (categorie_esar.label, ' - ', categorie_esar.name) AS label,
		id_pret as etat_pret
	FROM jeu
		LEFT OUTER JOIN categorie_esar ON jeu.categorie_esar_id = categorie_esar.id
		LEFT OUTER JOIN prets ON (jeu.id_jeu = prets.id_jeu AND date_retour > curdate())
	ORDER BY nom"; 
$data->select($sql, $rset);
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
do { ?>
	<tr>
		<td>
			<a href="index.php?o=games&a=edit&i=<?=$rset->value("id_jeu")?>"><?=$rset->value("nom")?></a>
		</td>
		<td>
			<?=$rset->value("label")?>
		</td>
		<td>
			<?=($rset->value("etat_pret") == "") ? "Libre" : "Emprunte"?>
		</td>
	</tr>
<?php } while($rset->nextrow()); ?>
	</tbody>
</table>
<script>
$(document).ready(function() {$('#list_jeu').DataTable({"autoWidth": false})});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
