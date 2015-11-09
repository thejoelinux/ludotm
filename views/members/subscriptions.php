<div class="panel panel-default">
  <div class="panel-heading">
  		<h4><span class="glyphicon glyphicon-user" style="margin-right: 10px" ></span>
			<?=$member->nom." ".$member->prenom." - Adhésions"?>
		</h4>
  </div>
  <div class="panel-body">

<table id="subscriptions_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th>Début</th>
			<th>Fin</th>
			<th>Type</th>
			<th>Paiement</th>
			<th>Crédit</th>
			<th>Prix</th>
			<th>Notes</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php if(!sizeof($member->subscriptions)) { ?>
	<tr>
		<th colspan="8">
		<div class="alert alert-warning" role="alert">Aucune adhésion</div>
		</th>
	</tr>
	<?php } else { while(list($key, $val) = each($member->subscriptions)) { ?>
	<tr>
		<td><?=$val->start_date?></td>
		<td><?=$val->end_date?></td>
		<td><?=$val->membership_type_name?></td>
		<td><?=$val->payment_method_name?></td>
		<td><?=$val->credit?></td>
		<td><?=$val->price?></td>
		<td><?=$val->comments?></td>
		<td>
			<a href="index.php?o=subscriptions&a=edit&i=<?=$val->id?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
			</a>
			<a onClick="if(confirm('Êtes vous sur ?')) { set_value('a', 'delete_subscription'); set_value('i', '<?=$val->id?>'); defaultform.submit()}" href="#">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } } ?>
</table>

<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la fiche adhérent">
		<span class="btn btn-success btm-md" onClick="set_value('a', 'new'); set_value('o', 'subscriptions'); defaultform.submit()">
			<i class="glyphicon glyphicon-plus"></i>
			<span>Nouvelle adhésion...</span>
		</span>
	</div>
</div>

  <!-- end of panel -->
  </div>
</div>

<script>
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=members&a=edit&i=<?=$member->id_adherent?>';
});
</script>
