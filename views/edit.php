<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="name" name="name" class="form-control" value="<?=$membership_type->name?>"/>
    </div>
    <label class="control-label col-sm-2" for="prix">Prix</label>
    <div class="col-sm-4">
        <input type="text" id="prix" name="prix" class="form-control" value="<?=$membership_type->price?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="description">Description</label>
    <div class="col-sm-10">
        <textarea id="description" name="description" class="form-control" rows="4"><?=$game->description?></textarea>
    </div>
</div>
<div class="form-group">
<?php if ($game->id_jeu != 0) { ?>
	<div class="col-sm-4 col-sm-offset-4">
    <input type="submit" class="btn btn-primary" value="Enregistrer les changements" onClick="set_value('a', 'update');">
    <input type="button" class="btn btn-danger" value="Supprimer" onClick="if(confirm('Really ?')) {set_value('a','delete'); defaultform.submit()}">
<?php } else { ?>
	<div class="col-sm-2 col-sm-offset-6">
    <input type="button" class="btn btn-primary" value="Créer" onClick="set_value('a', 'create');validate_and_submit()">
<?php } ?>
	</div>
</div>
