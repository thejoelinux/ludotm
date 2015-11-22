<div class="panel panel-default">
  <div class="panel-heading">
	<span style="font-size: 150%;" class="glyphicon glyphicon-user"></span>
  	<span style="font-size: 150%; font-weight: bold">
			Utilisateurs
	</span>

	<span class="btn btn-success btn-md" style="float: right" id="new_button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvel utilisateur...</span>
	</span>
</div>

  </div>
  <div class="panel-body">

<table id="users_list" class="col-sm-12" width="100%">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Mail</th>
			<th>Activé</th>
			<th>Actions</th>
		</tr>
	</thead>
	<?php while(list($key, $val) = each($users)) { ?>
	<tr>
		<td><?=$val->name?></td>
		<td><?=$val->email?></td>
		<td><input type="checkbox" id="active_<?=$val->id?>" name="active_<?=$val->id?>" class="form-control active_cbx" 
			data-switch-with-ajax <?=($val->active ? " checked " : "")?></td>
		<td>
			<a href="index.php?o=users&a=edit&i=<?=$val->id?>">
				<button type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
			</a>
			<a onClick="if(confirm('Êtes vous sur ?')) { $('#a').val('delete_user'); $('#i').val('<?=$val->id?>'); defaultform.submit()}" href="#">
				<button type="button" class="btn btn-danger btn-sm">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</a>
		</td>
	<?php } ?>
</table>

  <!-- end of panel -->
  </div>
</div>

<script>
$(document).ready(function () {
	$('#new_button').click(function(){
		$('#a').val('new');
		$('#o').val('users');
		defaultform.submit();
	});
	$('.active_cbx').bootstrapSwitch({
		onText: "Oui",
		offText: "Non",
	}).on('switchChange.bootstrapSwitch', function(event, state) {
		  $.ajax({
			url: 'api.php?o=users&a=switch_state&i=' + this.name.substr(7)
				+ "&state=" +  (state ? 1 : 0), // post on the API
			type: 'POST',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				return myXhr;
			},
			success: function(){
                    if(state) {
                        alert('Le compte utilisateur est activé.');
                    } else {
    					alert('Le compte utilisateur est à présent désactivé.');
                    }
				},
			error: function(){},
			cache: false,
			contentType: false,
			processData: false
		});
	});
});
</script>
