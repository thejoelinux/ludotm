<div class="panel panel-default">
  <div class="panel-heading">
		<h4><!--  class="panel-title" -->
  		<span class="glyphicon glyphicon-th-list" style="margin-right: 10px" ></span>
		<?=($subscription->id != 0) ? $subscription->member_name." - Adhésion du ".$subscription->start_date : "Nouvelle adhésion"?>
		</h4>
  </div>
  <div class="panel-body">

<div class="form-group">
    <label class="control-label col-sm-2" for="start_date">Début</label>
    <div class="col-sm-4">
		<div class='input-group date' id='start_datetimepicker'>
        	<input type="text" id="start_date" name="start_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#start_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($subscription->start_date != ""
						? "'".$subscription->start_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#start_date') = ev.format();
		        });
            });
        </script>
    </div> 
	<!-- TODO : these are dependant fields -->
	<label class="control-label col-sm-2" for="end_date">Fin</label>
    <div class="col-sm-4">
		<div class='input-group date' id='end_datetimepicker'>
        	<input type="text" id="end_date" name="end_date" class="form-control"/>
			<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
		<script type="text/javascript">
            $(function () {
                $('#end_datetimepicker').datetimepicker({
					locale: 'fr',
					format: 'DD-MM-YYYY',
					defaultDate: new Date(<?=($subscription->end_date != ""
						? "'".$subscription->end_date."'" : "")?>)
				})
				.on('changeDate', function(ev){
           			 $('#end_date') = ev.format();
		        });
            });
        </script>
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
	<label class="control-label col-sm-2" for="payment_method_id">Méthode de paiement</label>
    <div class="col-sm-4">
        <select id="payment_method_id" name="payment_method_id" class="form-control">
		</select>
		<script>
		$('#payment_method_id').html('<option value="">Loading...</option>');
		$.ajax({url: 'api.php?o=payment_methods&a=list',
             success: function(output) {
				var html = '';
				$.each(output, function(key, val){
				  html = html + '<option value="' + val.id + '"'
				  		+ (val.id == <?=(int)$subscription->payment_method_id?> ? ' selected ' : '' ) + '>'
						+ val.name + '</option>';
				});
                $('#payment_method_id').html(html);
            },
          error: function (xhr, ajaxOptions, thrownError) {
		  	// well, that's weird, ok :)
		  	$('#payment_method_id').html('<option value="">' + xhr.status + ' ' + thrownError + '</option>');
            // alert(xhr.status + " " + thrownError);
        }});
		</script>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="price">Prix</label>
    <div class="col-sm-4">
        <input type="text" id="price" name="price" class="form-control" value="<?=$subscription->price?>"/>
    </div>
    <label class="control-label col-sm-2" for="credit">Crédit</label>
    <div class="col-sm-1">
        <input type="checkbox" id="credit" name="credit" class="form-control" 
			<?=($subscription->credit ? "checked" : "")?>/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="comments">Commentaire</label>
    <div class="col-sm-10">
        <textarea id="comments" name="comments" class="form-control" rows="4"><?=$subscription->comments?></textarea>
    </div>
</div>
<input type="hidden" name="member_id" id="member_id" value="<?=$subscription->member_id?>">
<div class="form-group">
	<div class="col-sm-12" align="center">
		<input type="button" class="btn btn-primary" id="back_button" value="&lt;&lt; Retour à la liste">
<?php if ($subscription->id != 0) { ?>
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
    if(document.defaultform.start_date.value == 0) {
        alert ("Vous n'avez pas saisi de date de début !");
        return false;
    }
	// go to the members controllers, as this action should display
	// the list of the subscriptions for the current user
	$('#o').val('members');
	if($('#i').val() == 0) {
		$('#a').val('create_subscription');
	} else {
		$('#a').val('update_subscription');
	}
    document.defaultform.submit();
    return true;
});
$('#delete_button').click(function(){
	var msg = 'Voulez-vous réellement supprimer une subscription ?\n' + 
		'Cette action n\'est possible qu\'en cas d\'erreur de saisie.\n';
	if(confirm(msg)) {
		$('#a').val('delete_subscription');
    	document.defaultform.submit();
	}
});
$('#back_button').click(function(){
	// TODO this function should verify that the object has not been modified
	// and if yes, ask for confirmation from the user.
	window.location.href='index.php?o=members&a=subscriptions&i=<?=$subscription->member_id?>';
});
</script>

