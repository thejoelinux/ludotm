<?php
/*
This file is part of phpLudoreve.

    phpLudoreve is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    phpLudoreve is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with phpLudoreve.  If not, see <http://www.gnu.org/licenses/>.
*/

session_start();
function __autoload($class_name) {
    include "classes/".strtolower($class_name).".php";
}
include("config/config.php");
global $data;
$data = new data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/zabuto_calendar.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
	<!-- link rel="stylesheet" href="css/datatables.min.css" -->
	<link rel="stylesheet" href="css/styles.css">
	<script src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
	  	data-target="#navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">
	  	<img id="logo" src="images/logo-texte.png" alt="phpLudoreve"></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse navbar-right">
      <ul class="nav navbar-nav">
    	<li><a href="index.php?o=members">Adhérents</a></li>
    	<li><a href="index.php?o=games">Jeux</a></li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
		  	aria-expanded="false">Options <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?o=membership_types&a=list">Types d'adhésion</a></li>
            <li><a href="index.php?o=payment_methods&a=list">Méthodes de paiement</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
	  <form class="navbar-form navbar-right">
        <div id="search-all" >
            <input class="typeahead" type="text" placeholder="Recherche...">
        </div>
	  </form>
	  <!-- when authentication will be ready
	  <ul class="nav navbar-nav navbar-right">
        <li><a href="#/users"><span class="glyphicon glyphicon-user"></span> Account</a></li>
        <li><a href="#/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
	  -->
    </div>
  </div>
</nav>
<?php
// compute date
include("helpers/date.php");
?>
<form action="index.php" method="POST" id="defaultform" name="defaultform" 
	class="form-horizontal" enctype="multipart/form-data">
	<!-- div class="col-sm-9 col-md-10 main" -->
	<div class="container">
<?php
if(array_key_exists("o", $_REQUEST) && $_REQUEST["o"] != ""
	&& file_exists("controllers/".$_REQUEST["o"].".php")) {
        include("controllers/".$_REQUEST["o"].".php");
} else {
    $_REQUEST["o"] = "home";
    include("controllers/home.php");
}
?>
	</div>
	<input type="hidden" name="o" id="o" value="<?=$_REQUEST["o"]?>"> 
	<input type="hidden" name="a" id="a" value="<?=(array_key_exists("a", $_REQUEST)) ? $_REQUEST["a"] : ""?>"> 
	<input type="hidden" name="i" id="i" value="<?=(array_key_exists("i", $_REQUEST)) ? $_REQUEST["i"] : ""?>">
</form>
<footer>
<?php if($debug) { ?>
<pre>
REQUEST :
<?php print_r($_REQUEST) ?>
SESSION :
<?php print_r($_SESSION) ?>
</pre>
<?php } ?>
</footer>
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<!-- script src="js/datatables.js"></script -->
<script src="js/zabuto_calendar.min.js"></script>
<script src="js/typeahead.bundle.min.js"></script>
<script src="js/moment-with-locales.min.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script src="js/functions.js"></script>
<script type="application/javascript">
$(document).ready(function () {
    var members = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: { url : 'api.php?o=members&a=name_list',
	  	cache: false }
    });

    var games = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: { url : 'api.php?o=games&a=name_list',
	  	cache: false }
    });

    $('#search-members .typeahead').typeahead({
        highlight: true
    },
    {
      name: 'members',
      display: 'nom',
      source: members,
      templates: {
        header: '<h3 class="category-name">Adhérents</h3>'
      }
    });
        

    $('#search-all .typeahead').typeahead({
      highlight: true
    },
    {
      name: 'members',
      display: 'nom',
      source: members,
      templates: {
        header: '<h3 class="category-name">Adhérents</h3>'
      }
    },
    {
      name: 'games',
      display: 'nom',
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
        if(typeof datum.id_jeu !== 'undefined') {
            window.location.href = "index.php?o=games&a=edit&i=" + datum.id_jeu;
        } else {
            window.location.href = "index.php?o=members&a=edit&i=" + datum.id_adherent;
        }
    });

});
/*
TODO : Display calendar events via ajax
See documentation at https://github.com/zabuto/calendar
*/
</script>
</body>
</html>
