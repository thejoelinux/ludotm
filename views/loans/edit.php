<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-th-list" style="margin-right: 10px" ></span>
		<?=($loan->id_pret != 0) ? $loan->member_name." - Emprunt du ".$loan->date_pret : "Nouvel emprunt"?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="date_pret">Début</label>
    <div class="col-sm-4">
		<div class='input-group date' id='date_prettimepicker'>
        	<input type="text" id="date_pret" name="date_pret" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#date_prettimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($loan->date_pret != ""
						? "'".$loan->date_pret."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#date_pret') = ev.format();
		        });
            });
        </script>
    </div> 
	<!-- TODO : these are dependant fields -->
	<label class="control-label col-sm-2" for="date_retour">Fin</label>
    <div class="col-sm-4">
		<div class='input-group date' id='date_retourtimepicker'>
        	<input type="text" id="date_retour" name="date_retour" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#date_retourtimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($loan->date_retour != ""
						? "'".$loan->date_retour."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#date_retour') = ev.format();
		        });
            });
        </script>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="id_jeu">Jeu</label>
    <div class="col-sm-4">
	    <input type="hidden" name="id_jeu" id="id_jeu" value="">
	    <div id="search-games" >
			<input class="typeahead form-control" type="text" placeholder="Jeu...">
		</div>
    </div>
	<label class="control-label col-sm-2" for="rendu">Rendu ?</label>
    <div class="col-sm-1">
        <input type="checkbox" id="rendu" name="rendu" class="form-control" 
			<?=($loan->rendu ? "checked" : "")?>/>
    </div>
</div>
<input type="hidden" name="id_adherent" id="id_adherent" value="<?=$loan->member_id?>">
<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($loan->id_pret != 0) { ?>
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
    if(document.defaultform.date_pret.value == 0) {
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
	var msg = 'Voulez-vous réellement supprimer une loan ?\n' + 
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

