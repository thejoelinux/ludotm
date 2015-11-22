<div class="panel panel-default">
  <div class="panel-heading">
		<h4>
  		<span class="glyphicon glyphicon-list-alt" style="margin-right: 10px" ></span>
		<?=($esar_category->id != 0) ? "Catégorie ESAR : ".$esar_category->name : "Nouvelle catégorie ESAR"?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="name" name="name" class="form-control" value="<?=$esar_category->name?>"/>
    </div>
    <label class="control-label col-sm-2" for="label">label</label>
    <div class="col-sm-4">
        <input type="text" id="label" name="label" class="form-control" value="<?=$esar_category->label?>"/>
    </div>
</div>
<div class="form-group">
	<div class="col-sm-12" align="center">
	<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($esar_category->id != 0) { ?>
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
	var msg = 'Voulez-vous réellement supprimer cette catégorie ?\n' + 
		'Cette action n\'est possible que si celle-ci n\'a pas été\n' +
		'utilisée pour la classification d\'un jeu.';
	if(confirm(msg)) {
		$('#a').val('delete');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=esar_categories&a=list';
});
</script>
