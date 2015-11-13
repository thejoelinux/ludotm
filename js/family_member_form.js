// get the family_members list from API
function loadFamilyMembers(id) {
	$.ajax({
		url: 'api.php?o=family_members&a=list&i=' + id, // post on the API
		type: 'GET',
		xhr: function() {  // Custom XMLHttpRequest
			var myXhr = $.ajaxSettings.xhr();
			return myXhr;
		},
		success: completeFamilyHandler,
		// error: errorHandler,
		//Options to tell jQuery not to process data or worry about content-type.
		cache: false,
		contentType: false,
		processData: false
	});
}

// when the loading is complete, display the family_members
function completeFamilyHandler (response) { // response is an array of family_members
	var html = 'Aucun membre de famille associé.';
	if(response.length) {
		html = '';
		$.each(response, function(key, val){
			html = html + '<div id="fm_' + val.id + '" class="thumbnail col-sm-2" style="text-align: center">'
				+ '<strong>' + val.lastname + '</strong><br>' + val.firstname + '<br>'
				+ val.birth_date
				+ '<div class="caption">' + val.link_name
				+ ' <a href="javascript:deleteFamilyMember(' + val.id + ')" class="glyphicon glyphicon-remove"></a></div></div>';
		});
	}
	$('#family_member_list').html(html);
}

// delete a family_member, get back the resulting list
function deleteFamilyMember(id) {
	if(confirm('Etes-vous sur de vouloir effacer ce membre de la famille ?')) {
		$.ajax({
			url: 'api.php?o=family_members&a=delete&i=' + id, // on the API
			type: 'GET',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				return myXhr;
			},
			success: completeFamilyHandler,
			// error: errorHandler,
			//Options to tell jQuery not to process data or worry about content-type.
			cache: false,
			contentType: false,
			processData: false
		});
	}
}

// send a new file via an AJAX call, in case of success
// refresh the family_member list with the response
$(document).ready(function () {
	$('#add_family_member').click(function(){
		set_value('o', 'family_members');
		set_value('a', 'add');
		var formData = new FormData($('#defaultform')[0]);
		$.ajax({
			url: 'api.php', // post on the API
			type: 'POST',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				return myXhr;
			},
			success: completeFamilyHandler,
			error: function(){alert('Erreur lors de l\'ajout du membre de la famille.')},
			// Form data
			data: formData,
			//Options to tell jQuery not to process data or worry about content-type.
			cache: false,
			contentType: false,
			processData: false
		});
		// restore values
		set_value('o', 'members');
		set_value('a', 'edit');
	});
});
