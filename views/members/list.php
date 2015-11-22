<div class="panel panel-default">
  <div class="panel-heading">
	<span style="font-size: 150%;" class="glyphicon glyphicon-user"></span>
  	<span style="font-size: 150%; font-weight: bold">
    Adhérents
    <span class="btn btn-success btn-md" style="float: right" id="new_button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvel adhérent...</span>
	</span>
  </div>

</div>
<div class="panel-body">

<div class="col-sm-12" align="center">
<table id="list_member" style="display:none">
	<thead>
		<tr>
		<th>Nom</th>
		<th>Ville</th>
		<th>Etat</th>
		</tr>
	</thead>
	<tbody>
<?php
while(list($key, $val) = each($members)) { ?>
	<tr>
		<td>
			<a href="index.php?o=members&a=edit&i=<?=$val->id?>"><?=$val->lastname?> <?=$val->firstname?></a>
		</td>
		<td>
			<?=$val->po_town?>
		</td>
		<td>
            FIXME
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>
  <!-- end of panel -->
  </div>
</div>
<script>
$(document).ready(function() {
    $('#list_member').DataTable({
        "autoWidth": false,
        "fnDrawCallback": function() {
           $(this).show();
        }
    })
    $('#new_button').click(function(){
		$('#a').val('new');
		defaultform.submit();
	});
});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
