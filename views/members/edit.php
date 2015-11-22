<?php
// since we are in the edit form, we have an existing $member from the controller
?>
<div class="panel panel-default">
  <div class="panel-heading">
  		<h4><span class="glyphicon glyphicon-user" style="margin-right: 10px" ></span>
	<?=($member->id != 0) ? $member->lastname." ".$member->firstname : "Nouvel adhérent"?>
		
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="lastname">Nom</label>
    <div class="col-sm-4">
        <input type="text" id="lastname" name="lastname" class="form-control" value="<?=$member->lastname?>"/>
    </div>
    <label class="control-label col-sm-2" for="firstname">Prénom</label>
    <div class="col-sm-4">
        <input type="text" id="firstname" name="firstname" class="form-control" value="<?=$member->firstname?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="birth_date">Date de naissance</label>
    <div class="col-sm-4">
		<div class='input-group date' id='birth_datetimepicker'>
        	<input type="text" id="birth_date" name="birth_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#birth_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($member->birth_date != "" && $member->birth_date != "0000-00-00"
						? "'".$member->birth_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#birth_date') = ev.format();
		        });
				<?php if($member->birth_date == "" || $member->birth_date == "0000-00-00") { ?>
				$('#birth_date').val('');
				<?php } ?>
            });
        </script>
    </div>
    <label class="control-label col-sm-2" for="member_ref">Numéro adhérent</label>
    <div class="col-sm-4">
        <input type="text" id="member_ref" name="member_ref" class="form-control" value="<?=$member->member_ref?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="address">Adresse</label>
    <div class="col-sm-4">
        <textarea id="address" name="address" class="form-control" rows="2"><?=$member->address?></textarea>
    </div>
    <label class="control-label col-sm-2" for="po_town">Code postal - Ville</label>
    <div class="col-sm-4">
        <input type="text" id="po_town" name="po_town" class="form-control" value="<?=$member->po_town?>"/>
    </div>
	<!-- TODO auto complete on the existing values -->
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="email">Mail</label>
    <div class="col-sm-4">
        <input type="text" id="email" name="email" class="form-control" value="<?=$member->email?>"/>
    </div>
    <label class="control-label col-sm-2" for="newsletter">Newsletter</label>
    <div class="col-sm-1">
		<input type="hidden" id="newsletter" name="newsletter"
			value="<?=($member->newsletter ? 1 : 0)?>"/>
        <input type="checkbox" id="newsletter_cbx" name="newsletter_cbx" class="form-control" 
			<?=($member->newsletter ? "checked" : "")?>/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="home_phone">Tél. maison</label>
    <div class="col-sm-4">
        <input type="text" id="home_phone" name="home_phone" class="form-control" value="<?=$member->home_phone?>">
    </div>
    <label class="control-label col-sm-2" for="work_phone">Tél. travail</label>
    <div class="col-sm-4">
        <input type="text" id="work_phone" name="work_phone" class="form-control" value="<?=$member->work_phone?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="mobile_phone">Tél. mobile</label>
    <div class="col-sm-4">
        <input type="text" id="mobile_phone" name="mobile_phone" class="form-control" value="<?=$member->mobile_phone?>">
    </div>
    <label class="control-label col-sm-2" for="fax_phone">Fax</label>
    <div class="col-sm-4">
        <input type="text" id="fax_phone" name="fax_phone" class="form-control" value="<?=$member->fax_phone?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="member_subscription">Adhesion</label>
	<?php if ($member->id == 0) { ?>
	<div class="col-sm-10" style="margin-top: 5px">
		Il faut enregistrer l'adhérent avant de pouvoir enregistrer des adhésions et des emprunts.
	</div>
	<?php } else { ?>
	<div class="col-sm-4">
		<div class="input-group">
          <input type="text" id="member_subscription" name="member_subscription"  class="form-control" 
		  	value="<?=(sizeof($member->subscriptions)) ? $member->subscriptions[0]->text() : "Aucune adhésion trouvée"?>"/>
          <div class="input-group-btn">
            <button type="button" id="member_subscriptions_btn" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span></button>
          </div>
        </div>
    </div>
	<?php
			if(!sizeof($member->subscriptions)) {
		?>
    <div class="col-sm-6" style="margin-top: 5px">
		Il faut ajouter une première adhésion avant de pouvoir enregistrer des emprunts.		
	</div>
		<?php
			} else {
	?>

	<label class="control-label col-sm-2" for="adhesion">Emprunts</label>
    <div class="col-sm-4">
		<div class="input-group">
		  <input type="text" id="loans" name="loans" class="form-control" 
		  	value="<?=(sizeof($member->loans)) ? $member->loans_text() : "Aucun emprunt trouvé"?>">
	      <div class="input-group-btn">
            <button type="button" id="member_loans_btn" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span></button>
          </div>
		</div>	  
    </div>
</div>	
<div class="form-group">
    <label class="control-label col-sm-2" for="deposit">Caution</label>
    <div class="col-sm-1">
		<input type="hidden" id="deposit" name="deposit"
			value="<?=($member->deposit ? 1 : 0)?>" />
        <input type="checkbox" id="deposit_cbx" name="deposit_cbx" class="form-control" 
			<?=($member->deposit ? "checked" : "")?>/>
    </div>
    <label class="control-label col-sm-2 col-sm-offset-3" for="deposit_expiration_date">Limite validité</label>
	<div class="col-sm-4">
		<div class='input-group date' id='deposit_expiration_datetimepicker'>
        	<input type="text" id="deposit_expiration_date" name="deposit_expiration_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#deposit_expiration_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($member->deposit_expiration_date != "" && $member->deposit_expiration_date != "0000-00-00"
						? "'".$member->deposit_expiration_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#deposit_expiration_date') = ev.format();
		        });
				<?php if($member->deposit_expiration_date == "" || $member->deposit_expiration_date == "0000-00-00") { ?>
				$('#deposit_expiration_date').val('');
				<?php } ?>
            });
        </script>
    </div>
	<?php }
	} ?>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="family_members">Membres de la famille</label>
<?php if ($member->id == 0) { ?>
	<div class="col-sm-10" style="margin-top: 5px">
		Il faut enregistrer l'adhérent avant d'ajouter des membres de la famille.
	</div>
<?php } else { ?>
	<div class="col-sm-10">
		<div id="family_member_list"></div>
		<script src="js/family_member_form.js"></script>
		<script>
		// fire this fonction when the dom is ready
		$(document).ready(function () {
			loadFamilyMembers(<?=$member->id?>);
		});
		</script>
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-1 col-sm-offset-2" for="fm_lastname">Nom</label>
    <div class="col-sm-2">
        <input type="text" id="fm_lastname" name="fm_lastname" class="form-control" value="<?=$member->lastname?>"/>
    </div>
	<label class="control-label col-sm-1" for="fm_firstname">Prénom</label>
    <div class="col-sm-2">
        <input type="text" id="fm_firstname" name="fm_firstname" class="form-control" value=""/>
    </div>
	<label class="control-label col-sm-1" for="fm_birth_date">DDN</label>
	<div class="col-sm-2">
		<div class='input-group date' id='fm_birth_datetimepicker'>
        	<input type="text" id="fm_birth_date" name="fm_birth_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#fm_birth_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date()
				})
				.on('changeDate', function(ev){
           			 $('#fm_birth_date') = ev.format();
		        });
            });
        </script>
    </div>
</div>
<div class="form-group">
	<label class="control-label col-sm-1 col-sm-offset-2" for="fm_link_id">Lien</label>
    <div class="col-sm-2">
        <select id="fm_link_id" name="fm_link_id" class="form-control">
		<?php while(list($key, $val) = each($member->family_links)) { ?>
			<option value="<?=$key?>"><?=$val?></option>
		<?php } ?>
		</select>
    </div>
	<div class="col-sm-2 col-sm-offset-2" align="center">
		<button type="button" class="btn btn-sm btn-success" id="add_family_member">
			<span class="glyphicon glyphicon-plus"> Ajouter...
		</button>
	</div>
<?php } ?>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="comments">Commentaire</label>
    <div class="col-sm-10">
        <textarea id="comments" name="comments" class="form-control" rows="4"><?=$member->comments?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="other_members">Autres personnes</label>
    <div class="col-sm-10">
        <textarea id="other_members" name="other_members" class="form-control" rows="4"><?=$member->other_members?></textarea>
    </div>
</div>

<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($member->id != 0) { ?>
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
	$('input[name="newsletter_cbx"]').on('switchChange.bootstrapSwitch', function(event, state) {
		$('#newsletter').val(state == true ? 1 : 0);
	});
	$('input[name="deposit_cbx"]').on('switchChange.bootstrapSwitch', function(event, state) {
		$('#deposit').val(state == true ? 1 : 0);
	});
	// buttons events
	$('#save_button').click(function(){
		if(document.defaultform.lastname.value == 0) {
			alert ("Vous n'avez pas saisi de nom!");
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
		var msg = 'Voulez-vous réellement supprimer un adhérent ?\n' + 
			'Cette action n\'est possible que si l\'adhérent n\'a fait aucun\n' +
			'emprunt et payé aucune cotisation.';
		if(confirm(msg)) {
			$('#a').val('confirm_delete');
			document.defaultform.submit();
		}
	});
	$('#back_button').click(function(){
		// TODO this function should verify that the object has not been modified
		// and if yes, ask for confirmation from the user.
		window.location.href='index.php?o=members&a=list';
	});
	$('#member_subscriptions_btn').click(function(){
		window.location.href='index.php?o=members&a=subscriptions&i='+$('#i').val();
	});
	$('#member_loans_btn').click(function(){
		window.location.href='index.php?o=members&a=loans&i='+$('#i').val();
	});
});
</script>
