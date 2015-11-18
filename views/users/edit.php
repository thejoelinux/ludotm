<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-th-list" style="margin-right: 10px" ></span>
		<?=($luser->id != 0) ? $luser->name : "Nouvel utilisateur"?>
		</h4>
  </div>
  <div class="panel-body">
<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="name" name="name" class="form-control" value="<?=$luser->name?>"/>
    </div>
    <label class="control-label col-sm-2" for="email">Mail</label>
    <div class="col-sm-4">
        <input type="text" id="email" name="email" class="form-control" value="<?=$luser->email?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="membership_type_id">Type d'adhésion</label>
    <div class="col-sm-4">
        <select id="membership_type_id" name="membership_type_id" class="form-control">
		</select>
		<script>
		$('#membership_type_id').html('<option value="">Loading...</option>');
		$.ajax({url: 'api.php?o=membership_types&a=list',
             success: function(output) {
				var html = '';
				$.each(output, function(key, val){
				  html = html + '<option value="' + val.id + '"'
				  		+ (val.id == <?=(int)$subscription->membership_type_id?> ? ' selected ' : '' ) + '>'
						+ val.name + '</option>';
				});
                $('#membership_type_id').html(html);
            },
          error: function (xhr, ajaxOptions, thrownError) {
		  	// well, that's weird, ok :)
		  	$('#membership_type_id').html('<option value="">' + xhr.status + ' ' + thrownError + '</option>');
            // alert(xhr.status + " " + thrownError);
        }});
		</script>
    </div>
    <label class="control-label col-sm-2" for="active">Activé</label>
    <div class="col-sm-1">
        <input type="checkbox" id="active" name="active" class="form-control" 
			<?=($luser->active ? "checked" : "")?>/>
    </div>
</div>
<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($luser->id != 0) { ?>
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
    if(document.defaultform.name.value == 0) {
        alert ("Vous n'avez pas saisi de nom !");
        return false;
    }
	// go to the members controllers, as this action should display
	// the list of the subscriptions for the current user
	$('#o').val('users');
	if($('#i').val() == 0) {
		$('#a').val('create_user');
	} else {
		$('#a').val('update_user');
	}
    document.defaultform.submit();
    return true;
});
$('#delete_button').click(function(){
	var msg = 'Voulez-vous réellement supprimer un utilisateur ?\n' + 
		'Cette action n\'est possible qu\'en cas d\'erreur de saisie.\n';
	if(confirm(msg)) {
		$('#a').val('delete_user');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=users&a=list';
});
</script>

