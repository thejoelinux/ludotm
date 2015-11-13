<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-user" style="margin-right: 10px" ></span>
		<?=($membership_type->id != 0) ? "Adhésion : ".$membership_type->name : "Nouveau type d'adhésion"?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="name" name="name" class="form-control" value="<?=$membership_type->name?>"/>
    </div>
    <label class="control-label col-sm-2" for="price">Prix</label>
    <div class="col-sm-4">
        <input type="text" id="price" name="price" class="form-control" value="<?=$membership_type->price?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="description">Description</label>
    <div class="col-sm-10">
        <textarea id="description" name="description" class="form-control" rows="4"><?=$membership_type->description?></textarea>
    </div>
</div>
<div class="form-group">
	<div class="col-sm-12" align="center">
	<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($membership_type->id != 0) { ?>
    <input type="submit" class="btn btn-success" id="save_button" value="Enregistrer les changements">
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
	if($('#i').val() == 0) {
		$('#a').val('create');
	} else {
		$('#a').val('update');
	}
    document.defaultform.submit();
    return true;
});
$('#delete_button').click(function(){
	var msg = 'Voulez-vous réellement supprimer ce type d\'adhésion ?\n' + 
		'Cette action n\'est possible que si ce type n\'a été\n' +
		'utilisé pour l\'inscription d\'un adhérent.';
	if(confirm(msg)) {
		$('#a').val('delete');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=membership_types&a=list';
});
</script>
