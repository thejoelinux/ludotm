<div class="col-md-6 col-md-offset-3">
    <h2>Login</h2>
    <?php if($user->alert_msg != "") { ?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <?=$user->alert_msg?></div>
	<?php } ?>
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="name" id="name" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="passwd" id="passwd" class="form-control"/>
	</div>
	<div class="form-actions">
		<button class="btn btn-primary" id="login_button" name="login_button">Login</button>
		<a href="#/register" class="btn btn-link">Register</a>
	</div>
</div>
<script>
$(document).ready(function () {
	$('#login_button').click(function(){
		if(document.defaultform.name.value == 0) {
			alert ("Vous n'avez pas saisi de nom !");
			return false;
		}
		$('#a').val('submit_login');
		document.defaultform.submit();
		return true;
	});
});
</script>
