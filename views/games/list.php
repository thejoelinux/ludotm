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
while(list($key, $val) = each($games)) { ?>
	<tr>
		<td>
			<a href="index.php?o=games&a=edit&i=<?=$val->id_jeu?>"><?=$val->nom?></a>
		</td>
		<td>
			<?=$val->label?>
		</td>
		<td>
			<?=($val->etat_pret == "") ? "Libre" : "Emprunte"?>
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
<script>
$(document).ready(function() {
	$('#list_jeu').DataTable(
		/*{"autoWidth": false}*/
		)
/*		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');*/
});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
