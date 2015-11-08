<div class="col-sm-12" align="center">
	<h2><?=$member_subscriptions?> - Gestion des adhésions</h2>
</div>
<table id="member_subscriptions_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th width="">Date début</th>
			<th>Type d'adhésion</th>
			<th>Méthode de paiement</th>
			<th>Tarif</th>
		</tr>
	</thead>
	<?php while(list($key, $val) = each($member_subscriptions)) { ?>
	<tr>
		<th><?=$val->start_date?></th>
		<td><?=$val->membership_type_name?></td>
		<td><?=$val->payment_method_name?></td>
		<td><?=$val->price?></td>
		<td>
			<a href="index.php?o=member_subscriptions&a=edit&i=<?=$val->id?>">
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
		<span>Nouveau type</span>
	</span>
</div>
