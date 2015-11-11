<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-th-list" style="margin-right: 10px" ></span>
		<?=($loan->id != 0) ? $loan->game_name." - Emprunt du ".$loan->start_date : "Nouvel emprunt"?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="start_date">Début</label>
    <div class="col-sm-4">
		<div class='input-group date' id='start_datetimepicker'>
        	<input type="text" id="start_date" name="start_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#start_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($loan->start_date != ""
						? "'".$loan->start_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#start_date') = ev.format();
		        });
            });
        </script>
    </div> 
	<!-- TODO : these are dependant fields -->
	<label class="control-label col-sm-2" for="end_date">Fin</label>
    <div class="col-sm-4">
		<div class='input-group date' id='end_datetimepicker'>
        	<input type="text" id="end_date" name="end_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#end_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($loan->end_date != ""
						? "'".$loan->end_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#end_date') = ev.format();
		        });
            });
        </script>
    </div>
</div>
<div class="form-group">
	<?php if($loan->id == 0) { ?>
    <label class="control-label col-sm-2" for="game_id">Jeu</label>
    <div class="col-sm-4">
	    <input type="hidden" name="game_id" id="game_id" value="">
	    <div id="search-games-for-loans" >
			<input class="typeahead form-control" type="text" placeholder="Jeu...">
		</div>
    </div>
	<?php } else { ?>
	<!-- FIXME : this field may be a little bit useless when creating a new loan -->
	<label class="control-label col-sm-2" for="is_back">Rendu ?</label>
    <div class="col-sm-4">
        <input type="checkbox" id="is_back" name="is_back" class="form-control" 
			<?=($loan->is_back ? "checked" : "")?>/>
    </div>
	<?php } ?>
	<div class="control-label col-sm-6">
		Créé le : <?=$loan->created_at?> / Mis-à-jour le <?=$loan->updated_at?>
	</div>
</div>
<input type="hidden" name="member_id" id="member_id" value="<?=$loan->member_id?>">
<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($loan->id != 0) { ?>
    	<input type="button" class="btn btn-success" id="save_button" value="Enregistrer les changements">
	    <input type="button" class="btn btn-danger" id="delete_button" value="Supprimer">
<?php } else { ?>
    	<input type="button" class="btn btn-success" id="save_button" value="Créer">
<?php } ?>
	</div>
</div>

  <!-- end of panel -->
  </div>
</div>

<script>
// buttons events
$('#save_button').click(function(){
    if(document.defaultform.start_date.value == 0) {
        alert ("Vous n'avez pas saisi de date de début !");
        return false;
    }
	// go to the members controllers, as this action should display
	// the list of the loans for the current user
	$('#o').val('members');
	if($('#i').val() == 0) {
		$('#a').val('create_loan');
	} else {
		$('#a').val('update_loan');
	}
    document.defaultform.submit();
    return true;
});
$('#delete_button').click(function(){
	var msg = 'Voulez-vous réellement supprimer un emprunt ?\n' + 
		'Cette action n\'est possible qu\'en cas d\'erreur de saisie.\n';
	if(confirm(msg)) {
		$('#a').val('delete_loan');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=members&a=loans&i=<?=$loan->member_id?>';
});
</script>

