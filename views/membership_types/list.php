<div class="col-sm-12" align="center">
	<h2>Type d'adhésion</h2>
</div>
<table id="membership_types_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th width="">Nom</th>
			<th>Description</th>
			<th>Tarif</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php while(list($key, $val) = each($membership_types)) { ?>
	<tr>
		<th><?=$val->name?></th>
		<td><?=$val->description?></td>
		<td><?=$val->price?></td>
		<td>
			<a href="index.php?o=membership_types&a=edit&i=<?=$val->id?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifier
				</button>
			</a>
			<a href="index.php?o=membership_types&a=delete&i=<?=$val->id?>">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } ?>
</table>
<div class="col-sm-4 col-sm-offset-2" align="center">
	<span class="btn btn-success btm-md" onClick="set_value('a', 'new'); defaultform.submit()">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouveau type</span>
	</span>
</div>
