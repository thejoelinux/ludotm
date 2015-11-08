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
				  		+ (val.id == <?=(int)$member->membership_type_id?> ? ' selected ' : '' ) + '>'
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

