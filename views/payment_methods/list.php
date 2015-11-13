<div class="col-sm-12" align="center">
	<h2>Méthodes de paiement</h2>
</div>
<table id="payment_methods_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th width="">Nom</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php while(list($key, $val) = each($payment_methods)) { ?>
	<tr>
		<th><?=$val->name?></th>
		<td><?=$val->description?></td>
		<td>
			<a href="index.php?o=payment_methods&a=edit&i=<?=$val->id?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
			</a>
			<a onClick="if(confirm('Êtes vous sur ?')) { set_value('a', 'delete'); set_value('i', '<?=$val->id?>'); defaultform.submit()}" href="#">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } ?>
</table>
<div class="col-sm-8 col-sm-offset-2" align="center">
	<span class="btn btn-success btm-md" onClick="set_value('a', 'new'); defaultform.submit()">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvelle méthode...</span>
	</span>
</div>
