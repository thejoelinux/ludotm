<?php
/*
This file is part of phpLudoreve.

    phpLudoreve is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    phpLudoreve is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with phpLudoreve.  If not, see <http://www.gnu.org/licenses/>.
*/
// since we are in the edit form, we have an existing $game from the controller
?>
<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-knight" style="margin-right: 10px" ></span>
	<?php if($game->id != 0) { ?>
		<?=$game->name?>
		<small>
		<?php if($game->loan_id) { ?>
		(INDISPONIBLE) FIXME : lien vers pret en cours
		<?php } else { ?>
		(DISPONIBLE)
		<?php } ?>
		</small>
	<?php } else { ?>
		Nouveau jeu
	<?php } ?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="name">Nom</label>
    <div class="col-sm-10">
        <input type="text" id="name" name="name" class="form-control" value="<?=$game->name?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="reference">Référence</label>
    <div class="col-sm-4">
        <input type="text" id="reference" name="reference" class="form-control" value="<?=$game->reference?>"/>
    </div>	
    <label class="control-label col-sm-2" for="maker">Fabricant</label>
    <div class="col-sm-4">
        <input type="text" id="maker" name="maker" class="form-control" value="<?=$game->maker?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="maker_info">Infos fabricant</label>
    <div class="col-sm-4">
        <input type="text" id="maker_info" name="maker_info" class="form-control" value="<?=$game->maker_info?>"/>
    </div>
    <label class="control-label col-sm-2" for="price">Prix</label>
    <div class="col-sm-4">
        <input type="text" id="price" name="price" class="form-control" value="<?=$game->price?>"/>
    </div>
</div>
 <div class="form-group">
    <label class="control-label col-sm-2" for="category">Catégorie</label>
    <div class="col-sm-4">
        <input type="text" id="category" name="category" class="form-control" value="<?=$game->category?>"/>
    </div>
    <label class="control-label col-sm-2" for="esar_category_id">Catégorie ESAR</label>
    <div class="col-sm-4">
        <select id="esar_category_id" name="esar_category_id" class="form-control">
		</select>
		<script>
		$('#esar_category_id').html('<option value="">Loading...</option>');
		$.ajax({url: 'api.php?o=esar_categories&a=list',
             success: function(output) {
				var html = '';
				$.each(output, function(key, val){
				  html = html + '<option value="' + val.id + '"'
				  		+ (val.id == <?=(int)$game->esar_category_id?> ? ' selected ' : '' ) + '>'
						+ val.label + ' - ' + val.name + '</option>';
				});
                $('#esar_category_id').html(html);
            },
          error: function (xhr, ajaxOptions, thrownError) {
		  	// well, that's weird, ok :)
		  	$('#esar_category_id').html('<option value="">' + xhr.status + ' ' + thrownError + '</option>');
            // alert(xhr.status + " " + thrownError);
          }});
		</script>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2 col-xs-7" for="players_min">Nombre de joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="players_min" name="players_min" class="form-control" value="<?=$game->players_min?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="players_max">à</label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="players_max" name="players_max" class="form-control" value="<?=$game->players_max?>"/>
    </div>
    <label class="control-label col-sm-3 col-xs-7" for="age_min">Age des joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="age_min" name="age_min" class="form-control" value="<?=$game->age_min?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="age_max">à</label>
    <div class="col-sm-2 col-xs-1">
        <input type="text" id="age_max" name="age_max" class="form-control" value="<?=$game->age_max?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="game_type">Type de jeu</label>
    <div class="col-sm-4">
        <input type="text" id="game_type" name="game_type" class="form-control" value="<?=$game->game_type?>"/>
    </div>
    <label class="control-label col-sm-2" for="aquisition_date">Date d'achat</label>
    <div class="col-sm-4">
		<div class='input-group date' id='datetimepicker1'>
        	<input type="text" id="aquisition_date" name="aquisition_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($game->aquisition_date != ""
						? "'".$game->aquisition_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#aquisition_date') = ev.format();
		        });
            });
        </script>
    </div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="media">Medias</label>
<?php if ($game->id == 0) { ?>
	<div class="col-sm-10" style="margin-top: 5px">
		Il faut enregistrer le jeu avant d'ajouter des médias.
	</div>
<?php } else { ?>
	<div class="col-sm-2" align="center">
		<input type="file" name="media" id="media" class="form-control btn">
		<span class="btn btn-success fileinput-button" id="add_media">
			<i class="glyphicon glyphicon-plus"></i>
			<span>Ajouter...</span>
		</span>
	</div>
	<div class="col-sm-8">
		<div id="media_list"></div>
		<script src="js/media_form.js"></script>
		<script>
		// fire this fonction when the dom is ready
		$(document).ready(function () {
			loadMedias(<?=$game->id?>);
		});
		</script>
	</div>
<?php } ?>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="content_inventory">Inventaire</label>
    <div class="col-sm-10">
        <textarea id="content_inventory" name="content_inventory" class="form-control" rows="4"><?=$game->content_inventory?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="comments">Commentaire</label>
    <div class="col-sm-10">
        <textarea id="comments" name="comments" class="form-control" rows="4"><?=$game->comments?></textarea>
    </div>
</div>

<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($game->id != 0) { ?>
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
    if(dGocument.defaultform.nom.value == 0) {
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
	var msg = 'Voulez-vous réellement supprimer un jeu ?\n' + 
		'Cette action n\'est possible que si le jeu n\'a été\n' +
		'l\'objet d\'aucun emprunt.';
	if(confirm(msg)) {
		$('#a').val('confirm_delete');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=games&a=list';
});
</script>
