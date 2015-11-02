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
?>
<script>
function validate_and_submit () {
    if(document.defaultform.nom.value == 0) {
        alert ("Vous n'avez pas saisi le nom!");
        return false;
    }
    document.defaultform.submit();
    return true;
}
</script>
<?php
// since we are in the edit form, we have an existing $game from the controller
?>
<div class="col-sm-12" align="center">
	<?php if($game->id_jeu != 0) { ?>
		<h2><?=$game->nom?>
		<small>
		<?php if($game->id_pret) { ?>
		(INDISPONIBLE) FIXME : lien vers pret en cours
		<?php } else { ?>
		(DISPONIBLE)
		<?php } ?>
		</small></h2>
		<!-- FIXME : put this in a side bar helper <
		a href="index.php?o=prets&id_jeu=<?=$game->id_pret?>">Historique des prêts</a>
		-->
	<?php } else { ?>
		<h2>Nouveau jeu</h2>
	<?php } ?>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="nom">Nom</label>
    <div class="col-sm-10">
        <input type="text" id="nom" name="nom" class="form-control" value="<?=$game->nom?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="reference">Référence</label>
    <div class="col-sm-4">
        <input type="text" id="reference" name="reference" class="form-control" value="<?=$game->reference?>"/>
    </div>	
    <label class="control-label col-sm-2" for="fabricant">Fabricant</label>
    <div class="col-sm-4">
        <input type="text" id="fabricant" name="fabricant" class="form-control" value="<?=$game->fabricant?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="infos_fabricant">Infos fabricant</label>
    <div class="col-sm-4">
        <input type="text" id="infos_fabricant" name="infos_fabricant" class="form-control" value="<?=$game->infos_fabricant?>"/>
    </div>
    <label class="control-label col-sm-2" for="prix">Prix</label>
    <div class="col-sm-4">
        <input type="text" id="prix" name="prix" class="form-control" value="<?=$game->prix?>"/>
    </div>
</div>
 <div class="form-group">
    <label class="control-label col-sm-2" for="categorie">Catégorie (ex sy as rè)</label>
    <div class="col-sm-4">
        <input type="text" id="categorie" name="categorie" class="form-control" value="<?=$game->categorie?>"/>
    </div>
    <label class="control-label col-sm-2" for="categorie_esar_id">Catégorie ESAR</label>
    <div class="col-sm-4">
        <select id="categorie_esar_id" name="categorie_esar_id" class="form-control">
		</select>
		<script>
		$('#categorie_esar_id').html('<option value="">Loading...</option>');
		$.ajax({url: 'api.php?o=esar_categories&a=list',
             success: function(output) {
				var html = '';
				$.each(output, function(key, val){
				  html = html + '<option value=\"' + val.id + '\"'
				  		+ (val.id == <?=$game->categorie_esar_id?> ? ' selected ' : '' ) + '>'
						+ val.label + ' - ' + val.name + '</option>';
				});
                $('#categorie_esar_id').html(html);
            },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " "+ thrownError);
          }});
		</script>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2 col-xs-7" for="nombre_mini">Nombre de joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="nombre_mini" name="nombre_mini" class="form-control" value="<?=$game->nombre_mini?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="nombre_maxi">à</label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="nombre_maxi" name="nombre_maxi" class="form-control" value="<?=$game->nombre_maxi?>"/>
    </div>
    <label class="control-label col-sm-3 col-xs-7" for="age_mini">Age des joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="age_mini" name="age_mini" class="form-control" value="<?=$game->age_mini?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="age_maxi">à</label>
    <div class="col-sm-2 col-xs-1">
        <input type="text" id="age_maxi" name="age_maxi" class="form-control" value="<?=$game->age_maxi?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="type">Type de jeu</label>
    <div class="col-sm-4">
        <input type="text" id="type" name="type" class="form-control" value="<?=$game->type?>"/>
    </div>
    <label class="control-label col-sm-2" for="date_achat">Date d'achat</label>
    <div class="col-sm-4">
		<div class='input-group date' id='datetimepicker1'>
        	<input type="text" id="date_achat" name="date_achat" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($game->date_achat != ""
						? "'".$game->date_achat."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#date_achat') = ev.format();
		        });
            });
        </script>
    </div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="media">Medias</label>
	<div class="col-sm-10" style="margin-top: 5px">
	<?php if(sizeof($game->medias)) { ?>
		<div id="media_list">
		<?php 
		// DEBUG 
		echo "<pre>"; print_r($game->medias); echo "</pre>";
		while(list($key, $val) = each($game->medias)) { 
			?><div id="media_<?=$val->id?>"><?=$val->description?>
				<a href="javascript:delete_file(<?=$val->id?>)">Effacer</a>
			<?php
			if(preg_match("/.jpg$/", $val["file"])) { ?>
				<img width="100" height="80" src="uploads/<?=$val["file"]?>">
			<?php } ?></div><?php
		}
		?>
		</div>
	<?php } else { ?>
		Aucun média associé.
	<?php } ?>
	<?php if ($game->id_jeu != 0) { ?>
	<!-- begin medias form -->
		<input type="file" name="media" id="media"/>
		<input type="button" value="Ajouter" id="add_media" />
<script>
$('#add_media').click(function(){
	var formData = new FormData($('form')[0]);
    $.ajax({
        url: 'api.php?o=medias&a=upload&game_id=<?=$game->id_jeu?>', //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
			if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        //Ajax events
        //beforeSend: beforeSendHandler,
        success: completeHandler,
        // FIXME error: errorHandler,
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
});
function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}
function completeHandler (response) {
    $('#media_list').html(
        $('#media_list').html() + '<div id="media_' +
            response.id + '">' + response.description + 
            '<a href="javascript:delete_file(' + response.id + ')">Effacer</a>' +
			'FIXME' + response.file + '</div>'
            );
    alert(response);    
}
</script>
	<!-- end medias form -->	
	<?php } else { ?>
		Il faut enregistrer le jeu avant d'ajouter des médias.
	<?php } ?>
	</div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="inventaire">Inventaire</label>
    <div class="col-sm-10">
        <textarea id="inventaire" name="inventaire" class="form-control" rows="4"><?=$game->inventaire?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="commentaire">Commentaire</label>
    <div class="col-sm-10">
        <textarea id="commentaire" name="commentaire" class="form-control" rows="4"><?=$game->commentaire?></textarea>
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
