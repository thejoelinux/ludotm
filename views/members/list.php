<h1>Liste des adhérents</h1>
<table id="list_member">
	<thead>
		<tr>
		<th>Nom</th>
		<th>Ville</th>
		<th>Etat</th>
		</tr>
	</thead>
	<tbody>
<?php
while(list($key, $val) = each($members)) { ?>
	<tr>
		<td>
			<a href="index.php?o=members&a=edit&i=<?=$val->id_adherent?>"><?=$val->nom?> <?=$val->prenom?></a>
		</td>
		<td>
			<?=$val->cp_ville?>
		</td>
		<td>
            FIXME
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
<script>
$(document).ready(function() {$('#list_member').DataTable({"autoWidth": false})});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
