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
// since we are in the edit form, we have an existing $member from the controller
?>
<div class="col-sm-12" align="center">
	<?php if($member->id_adherent != 0) { ?>
		<h2><?=$member->nom?> <?=$member->prenom?></h2>
	<?php } else { ?>
		<h2>Nouvel adhérent</h2>
	<?php } ?>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="nom">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="nom" name="nom" class="form-control" value="<?=$member->nom?>"/>
    </div>
    <label class="control-label col-sm-2" for="prenom">Prénom</label>
    <div class="col-sm-4">
        <input type="text" id="prenom" name="prenom" class="form-control" value="<?=$member->prenom?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="date_naissance">Date de naissance</label>
    <div class="col-sm-4">
		<div class='input-group date' id='birth_datetimepicker'>
        	<input type="text" id="date_naissance" name="date_naissance" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#birth_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($member->date_naissance != ""
						? "'".$member->date_naissance."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#date_naissance') = ev.format();
		        });
            });
        </script>
    </div>
    <label class="control-label col-sm-2" for="num_adherent">Numéro adhérent</label>
    <div class="col-sm-4">
        <input type="text" id="num_adherent" name="num_adherent" class="form-control" value="<?=$member->num_adherent?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="adresse">Adresse</label>
    <div class="col-sm-4">
        <textarea id="adresse" name="adresse" class="form-control" rows="2"><?=$member->adresse?></textarea>
    </div>
    <label class="control-label col-sm-2" for="cp_ville">Code postal - Ville</label>
    <div class="col-sm-4">
        <input type="text" id="cp_ville" name="cp_ville" class="form-control" value="<?=$member->cp_ville?>"/>
    </div>
	<!-- TODO auto complete on the existing values -->
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="tel_maison">Tél. maison</label>
    <div class="col-sm-4">
        <input type="text" id="tel_maison" name="tel_maison" class="form-control" value="<?=$member->tel_maison?>">
    </div>
    <label class="control-label col-sm-2" for="tel_travail">Tél. travail</label>
    <div class="col-sm-4">
        <input type="text" id="tel_travail" name="tel_travail" class="form-control" value="<?=$member->tel_travail?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="tel_mobile">Tél. mobile</label>
    <div class="col-sm-4">
        <input type="text" id="tel_mobile" name="tel_mobile" class="form-control" value="<?=$member->tel_mobile?>">
    </div>
    <label class="control-label col-sm-2" for="tel_fax">Fax</label>
    <div class="col-sm-4">
        <input type="text" id="tel_fax" name="tel_fax" class="form-control" value="<?=$member->tel_fax?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="adhesion">Adhesion</label>
    <div class="col-sm-4">
        <input type="text" id="adhesion" name="adhesion" class="form-control" value="<?=$member->adhesion?>"/>
    </div>
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
				  		+ (val.id == <?=$member->membership_type_id?> ? ' selected ' : '' ) + '>'
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
</div>
<div class="form-group">
    <label class="control-label col-sm-2 col-xs-7" for="nombre_mini">Nombre de joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="nombre_mini" name="nombre_mini" class="form-control" value="<?=$member->nombre_mini?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="nombre_maxi">à</label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="nombre_maxi" name="nombre_maxi" class="form-control" value="<?=$member->nombre_maxi?>"/>
    </div>
    <label class="control-label col-sm-3 col-xs-7" for="age_mini">Age des joueurs de </label>
    <div class="col-sm-1 col-xs-1">
        <input type="text" id="age_mini" name="age_mini" class="form-control" value="<?=$member->age_mini?>"/>
    </div>
    <label class="control-label col-sm-1 col-xs-1" for="age_maxi">à</label>
    <div class="col-sm-2 col-xs-1">
        <input type="text" id="age_maxi" name="age_maxi" class="form-control" value="<?=$member->age_maxi?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="type">Type de jeu</label>
    <div class="col-sm-4">
        <input type="text" id="type" name="type" class="form-control" value="<?=$member->type?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="date_inscription">Date d'inscription</label>
    <div class="col-sm-4">
		<div class='input-group date' id='inscription_datetimepicker'>
        	<input type="text" id="date_inscription" name="date_inscription" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#inscription_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($member->date_inscription != ""
						? "'".$member->date_inscription."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#date_inscription') = ev.format();
		        });
            });
        </script>
    </div>

	<label class="control-label col-sm-2" for="media">Medias</label>
<?php if ($member->id_adherent == 0) { ?>
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
			loadMedias(<?=$member->id_adherent?>);
		});
		</script>
	</div>
<?php } ?>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="inventaire">Inventaire</label>
    <div class="col-sm-10">
        <textarea id="inventaire" name="inventaire" class="form-control" rows="4"><?=$member->inventaire?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="commentaire">Commentaire</label>
    <div class="col-sm-10">
        <textarea id="commentaire" name="commentaire" class="form-control" rows="4"><?=$member->commentaire?></textarea>
    </div>
</div>

<div class="form-group">
<?php if ($member->id_adherent != 0) { ?>
	<div class="col-sm-4 col-sm-offset-4">
    <input type="submit" class="btn btn-primary" value="Enregistrer les changements" onClick="set_value('a', 'update');">
    <input type="button" class="btn btn-danger" value="Supprimer" onClick="if(confirm('Really ?')) {set_value('a','delete'); defaultform.submit()}">
<?php } else { ?>
	<div class="col-sm-2 col-sm-offset-6">
    <input type="button" class="btn btn-primary" value="Créer" onClick="set_value('a', 'create');validate_and_submit()">
<?php } ?>
	</div>
</div>
