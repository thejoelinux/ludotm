<?php
// there is an existing $user fr om the controller
?>
<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-th-list" style="margin-right: 10px" ></span>
		<?=($user->id != 0) ? $user->name : "Nouvel utilisateur"?>
		</h4>
  </div>
  <div class="panel-body">
<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="name" name="name" class="form-control" value="<?=$user->name?>"/>
    </div>
    <label class="control-label col-sm-2" for="email">Mail</label>
    <div class="col-sm-4">
        <input type="text" id="email" name="email" class="form-control" value="<?=$user->email?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="roles">Roles</label>
    <div class="col-sm-4">
        <select id="roles" name="roles[]" class="form-control" multiple="multiple">
		</select>
		<script>
		$(document).ready(function() {
			$('#roles').html('<option value="">Loading...</option>');
			$.ajax({url: 'api.php?o=roles&a=user_list&i=<?=$user->id?>',
				 success: function(output) {
					var html = '';
					$.each(output, function(key, val){
					  html = html + '<option value="' + val.name + '"'
							+ (val.selected > 0 ? 'selected' : '') + '>'
							+ val.description + '</option>';
					});
					$('#roles').html(html);
					$('#roles').multiselect();
				},
			  error: function (xhr, ajaxOptions, thrownError) {
				// well, that's weird, ok :)
				$('#roles').html('<option value="">' + xhr.status + ' ' + thrownError + '</option>');
				// alert(xhr.status + " " + thrownError);
			  }
			});
	    });
		</script>
    </div>
    <label class="control-label col-sm-2" for="active">Activé</label>
    <div class="col-sm-1">
        <input type="hidden" id="active" name="active" value="<?=($user->active ? 1 : 0)?>/>"/>
        <input type="checkbox" id="active_cbx" class="form-control" 
			<?=($user->active ? "checked" : "")?>/>
    </div>
</div>
<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($user->id != 0) { ?>
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
$(document).ready(function () {
    // special checkbox
	$('#active_cbx').on('switchChange.bootstrapSwitch', function(event, state) {
		$('#active').val(state == true ? 1 : 0);
	});
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
            $('#a').val('create');
        } else {
            $('#a').val('update');
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
});
</script>
