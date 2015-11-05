<div class="col-sm-8" align="center">
	<h2>Type d'adhésion</h2>
</div>
<div class="col-sm-4" align="center">
	<span class="btn btn-success" onClick="set_value('a', 'new'); defaultform.submit()">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Nouveau type</span>
	</span>
</div>
<div class="col-sm-12" align="center">
<table id="membership_types_list" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="">Nom</th>
			<th>Description</th>
			<th>Tarif</th>
			<th>Actions</th>
		</tr>
	</thead>
</table>
</div>
<script>
$(document).ready(function() {
	$('#membership_types_list').DataTable( {
        "ajax": {
            "url": "api.php?o=membership_types&a=list",
            "dataSrc": ""
        },
        "columns": [
            { "data": "name" },
            { "data": "description" },
            { "data": "price" }
        ],
		"columnDefs": [ {
            "targets": 3,
            "data": null,
            "defaultContent": "<button>Click!</button>"
        } ]
    } );
});
</script>
