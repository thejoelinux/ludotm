<div class="panel panel-default">
  <div class="panel-heading">
	<span style="font-size: 150%;" class="glyphicon glyphicon-knight"></span>
  	<span style="font-size: 150%; font-weight: bold">
    Jeux
    </span>

<span class="btn btn-success btn-md" style="float: right" id="new_button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouvel jeu...</span>
	</span>
</div>

  </div>
  <div class="panel-body">


<div class="col-sm-12" align="center">
<table id="list_jeu">
	<thead>
		<tr>
		<th>Nom</th>
		<th>ESAR</th>
		<th>Etat</th>
		</tr>
	</thead>
	<tbody>
<?php
while(list($key, $val) = each($games)) { ?>
	<tr>
		<td>
			<a href="index.php?o=games&a=edit&i=<?=$val->id?>"><?=$val->name?></a>
		</td>
		<td>
			<?=$val->label?>
		</td>
		<td>
			<?=($val->loan_status == "") ? "Libre" : "Emprunte"?>
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
	$('#list_jeu').DataTable(
		/*{"autoWidth": false}*/
		)
/*		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');*/
    $('#new_button').click(function(){
		$('#a').val('new');
		defaultform.submit();
    });
});
/* FIXME : translation of the table
see https://datatables.net/plug-ins/i18n/French
*/
</script>
