<div class="panel panel-default">
  <div class="panel-heading">
	<span style="font-size: 150%;" class="glyphicon glyphicon-user"></span>
  	<span style="font-size: 150%; font-weight: bold">
    Catégories ESAR
	</span>

	<span class="btn btn-success btn-md" style="float: right" id="new_button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvelle catégorie...</span>
	</span>
  </div>

  </div>
  <div class="panel-body">

<div class="col-sm-12" align="center">
<table id="list_esar" style="display:none">
	<thead>
		<tr>
		<th>Label</th>
		<th>Description</th>
		</tr>
	</thead>
	<tbody>
<?php
while(list($key, $val) = each($esar_categories)) { ?>
	<tr>
		<td>
			<a href="index.php?o=esar_categories&a=edit&i=<?=$val->id?>"><?=$val->label?></a>
		</td>
		<td>
			<?=$val->name?>
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
    $('#list_esar').DataTable({
        "autoWidth": false,
        "fnDrawCallback": function() {
           $(this).show();
        }
    })
});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
