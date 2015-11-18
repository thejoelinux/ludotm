// get the media list from API
function loadMedias(id) {
	$.ajax({
		url: 'api.php?o=medias&a=list&i=' + id, // post on the API
		type: 'GET',
		xhr: function() {  // Custom XMLHttpRequest
			var myXhr = $.ajaxSettings.xhr();
			return myXhr;
		},
		success: completeMediaHandler,
		// error: errorHandler,
		//Options to tell jQuery not to process data or worry about content-type.
		cache: false,
		contentType: false,
		processData: false
	});
}

// when the loading is complete, display the media
function completeMediaHandler (response) { // response is an array of medias
	var html = 'Aucun media associé.';
	if(response.length) {
		html = '';
		$.each(response, function(key, val){
			html = html + '<div id="media_' + val.id + '" class="thumbnail col-sm-2" align="center">';
			if(val.mime_type !== null && val.mime_type.match('image')) {
				html = html + '<img width="100" height="80" '
					+ ' src="uploads/' + val.file + '" alt="' + val.description + '">';
			} else {
				html = html + '<a href="api.php?o=medias&a=download&i=' + val.id + '" target="new">'
					+ '<span class="glyphicon glyphicon-save"></span> ' + val.description + '</a>';
			}
			html = html + '<div class="caption">'
				+ '<a href="javascript:deleteMedia(' + val.id + ')"><span class="glyphicon glyphicon-remove"></span> Effacer</a></div></div>';
		});
	}
	$('#media_list').html(html);
}

// delete a media, get back the resulting list
function deleteMedia(id) {
	if(confirm('Etes-vous sur de vouloir supprimer ce media ?')) {
		$.ajax({
			url: 'api.php?o=medias&a=delete&i=' + id, // post on the API
			type: 'GET',
			xhr: function() {  // Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				return myXhr;
			},
			success: completeMediaHandler,
			// error: errorHandler,
			//Options to tell jQuery not to process data or worry about content-type.
			cache: false,
			contentType: false,
			processData: false
		});
	}
}

// send a new file via an AJAX call, in case of success
// refresh the media list with the response
$('#add_media').click(function(){
	$('#o').val('medias');
	$('#a').val('upload');
	var formData = new FormData($('#defaultform')[0]);
	$.ajax({
		url: 'api.php', // post on the API
		type: 'POST',
		xhr: function() {  // Custom XMLHttpRequest
			var myXhr = $.ajaxSettings.xhr();
			return myXhr;
		},
		success: completeMediaHandler,
		error: function(){alert('Erreur lors de l\'envoi du fichier.')},
		// Form data
		data: formData,
		//Options to tell jQuery not to process data or worry about content-type.
		cache: false,
		contentType: false,
		processData: false
	});
	// restore values
	$('#o').val('games');
	$('#a').val('edit');
});
