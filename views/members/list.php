<div class="col-sm-8" align="center">
	<h2>Liste des adhérents</h2>
</div>
<div class="col-sm-4" align="center">
	<span class="btn btn-success" onClick="$('#a').val('new'); defaultform.submit()">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvelle adhésion...</span>
	</span>
</div>
<div class="col-sm-12" align="center">
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
			<a href="index.php?o=members&a=edit&i=<?=$val->id?>"><?=$val->lastname?> <?=$val->firstname?></a>
		</td>
		<td>
			<?=$val->po_town?>
		</td>
		<td>
            FIXME
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>
<script>
$(document).ready(function() {$('#list_member').DataTable({"autoWidth": false})});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
