$(document).ready(function () {
    var members = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: { url : 'api.php?o=members&a=name_list',
	  	cache: false }
    });

    var games = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: { url : 'api.php?o=games&a=name_list',
	  	cache: false }
    });

    $('#search-members .typeahead').typeahead({
        highlight: true
    },
    {
      name: 'members',
      display: 'full_name',
      source: members,
      templates: {
        header: '<h3 class="category-name">Adhérents</h3>'
      }
    });

	$('#search-games-for-loans .typeahead').typeahead({
        highlight: true
    },
    {
      name: 'games',
      display: 'name',
      source: new Bloodhound({
	      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	      prefetch: { url : 'api.php?o=games&a=name_list&filter=available',
	  		cache: false }
      })
    }).bind('typeahead:selected', function(obj, datum, name) {      
        if(typeof datum.id !== 'undefined') {
			console.log(datum);
            $('#game_id').val(datum.id);
        }
    });

    $('#search-all .typeahead').typeahead({
      highlight: true
    },
    {
      name: 'members',
      display: 'full_name',
      source: members,
      templates: {
        header: '<h3 class="category-name">Adhérents</h3>'
      }
    },
    {
      name: 'games',
      display: 'name',
      source: games,
      templates: {
        header: '<h3 class="category-name">Jeux</h3>'
      }
    });
    // from https://github.com/twitter/typeahead.js/issues/300 suggestion
    $('#search-all').bind('typeahead:selected', function(obj, datum, name) {      
        // alert(JSON.stringify(datum)); // contains datum value, tokens and custom fields
        // outputs, e.g., {"redirect_url":"http://localhost/test/topic/test_topic","image_url":"http://localhost/test/upload/images/t_FWnYhhqd.jpg","description":"A test description","value":"A test value","tokens":["A","test","value"]}
        // in this case I created custom fields called 'redirect_url', 'image_url', 'description'   
        if(typeof datum.full_name !== 'undefined') {
            window.location.href = "index.php?o=members&a=edit&i=" + datum.id;
        } else {
            window.location.href = "index.php?o=games&a=edit&i=" + datum.id;
        }
    });
	// every check box on site turned into a switch except with data-switch-with-ajax flag
	$("input[type=\"checkbox\"]").not("[data-switch-with-ajax]").bootstrapSwitch({
		onText: "Oui",
		offText: "Non"
	});
});
/*
TODO : Display calendar events via ajax
See documentation at https://github.com/zabuto/calendar
*/
