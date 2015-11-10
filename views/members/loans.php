<div class="panel panel-default">
  <div class="panel-heading">
  		<h4><span class="glyphicon glyphicon-user" style="margin-right: 10px" ></span>
			<?=$member->lastname." ".$member->firstname." - Emprunts"?>
		</h4>
  </div>
  <div class="panel-body">

<table id="loans_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Date emprunt</th>
			<th>Date retour</th>
			<th>Rendu</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php if(!sizeof($member->loans)) { ?>
	<tr>
		<th colspan="5">
		<div class="alert alert-warning" role="alert">Aucun emprunt</div>
		</th>
	</tr>
	<?php } else { while(list($key, $val) = each($member->loans)) { ?>
	<tr>
		<td><?=$val->game_name?></td>
		<td><?=$val->start_date?></td>
		<td><?=$val->end_date?></td>
		<td><?=$val->is_back?></td>
		<td>
			<a href="index.php?o=loans&a=edit&i=<?=$val->idt?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
			</a>
			<a onClick="if(confirm('Êtes vous sur ?')) { set_value('a', 'delete_loan'); set_value('i', '<?=$val->id?>'); defaultform.submit()}" href="#">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } } ?>
</table>

<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la fiche adhérent">
		<span class="btn btn-success btm-md" onClick="set_value('a', 'new'); set_value('o', 'loans'); defaultform.submit()">
			<i class="glyphicon glyphicon-plus"></i>
			<span>Nouvel emprunt...</span>
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
	window.location.href='index.php?o=members&a=edit&i=<?=$member->id?>';
});
</script>
