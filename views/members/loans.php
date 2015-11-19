<div class="panel panel-default">
  <div class="panel-heading">
  		<span class="btn btn-primary" id="back_button">
  			<i class="glyphicon glyphicon-user"></i>
			Retour à la fiche adhérent
		</span>	

		<span style="font-size: 150%; font-weight: bold">&nbsp;<?=$member->lastname." ".$member->firstname." - Emprunts"?>&nbsp;</span>
		
		<?php if($member->has_valid_subscription()) { ?>
		<span class="btn btn-success btn-md" style="float: right" id="new_button">
			<i class="glyphicon glyphicon-plus"></i>
			<span>Nouvel emprunt...</span>
		</span>
		<?php } else { ?>
		<span class="btn btn-danger btn-md" style="float: right">
			<i class="glyphicon glyphicon-warning-sign"></i>
			<span>Impossible de faire un nouvel emprunt.</span>
		</span>
		<?php } ?>
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
		<td><?=$val->game_name?>
		<?=($val->is_late) ? "<span class=\"label label-warning\">En retard</span>" : "" ?>
		</td>
		<td><?=$val->start_date?></td>
		<td><?=$val->end_date?></td>
		<td><input type="checkbox" id="is_back_<?=$val->id?>" name="is_back_<?=$val->id?>" class="form-control is_back_cbx" 
			data-switch-with-ajax <?=($val->is_back ? " checked " : "")?></td>

		<td>
			<a href="index.php?o=loans&a=edit&i=<?=$val->id?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
			</a>
			<a onClick="if(confirm('Êtes vous sur ?')) { $('a').val('delete_loan'); $('#i').val('<?=$val->id?>'); defaultform.submit()}" href="#">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } } ?>
</table>

  <!-- end of panel -->
  </div>
</div>

<script>
$(document).ready(function () {
	$('#back_button').click(function(){
		// TODO this function should verify that the object has not been modified
		// and if yes, ask for confirmation from the user.
		window.location.href='index.php?o=members&a=edit&i=<?=$member->id?>';
	});
	$('#new_button').click(function(){
		$('#a').val('new');
		$('#o').val('loans');
		defaultform.submit();
	});
	$('.is_back_cbx').bootstrapSwitch({
		onText: "Oui",
		offText: "Non",
	}).on('switchChange.bootstrapSwitch', function(event, state) {
		  $.ajax({
			url: 'api.php?o=loans&a=switch_state&i=' + this.name.substr(8)
				+ "&state=" +  (state ? 1 : 0), // post on the API
			type: 'POST',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				return myXhr;
			},
			success: function(){
					alert('Le jeu est noté comme restitué aujourd\'hui.');
				},
			error: function(){
					alert('Une erreur a eu lieu lors de la restitution de ce jeu.');
				},
			cache: false,
			contentType: false,
			processData: false
		});
	});
});
</script>
