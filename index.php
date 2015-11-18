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
global $user;
$user = new User(0);
if(!array_key_exists("user_id", $_SESSION)) { 
	if(array_key_exists("a", $_REQUEST) && $_REQUEST["a"] == "submit_login") {
		// try to authenticate
		$user = User::validate($GLOBALS["data"]->db_escape_string($_REQUEST["name"]),
			$GLOBALS["data"]->db_escape_string($_REQUEST["passwd"]));
		if($user->id != 0) {
			$_SESSION["user_id"] = $user->id;
			$_REQUEST["o"] = "home";
		}
	} // stay not authenticated
} else {
	if(array_key_exists("a", $_REQUEST) && $_REQUEST["a"] == "logout") {
		// logout
		unset($_SESSION["user_id"]);
	} else {
		// stay authenticated
		$user = User::fetch($_SESSION["user_id"]);
	}
}
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
	<link rel="stylesheet" href="css/bootstrap-switch.min.css">
	<!-- link rel="stylesheet" href="css/datatables.min.css" -->
	<link rel="stylesheet" href="css/styles.css">
	<script src="js/jquery-2.1.4.min.js"></script>
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
	<?php if($user->id != 0) { 
		$menu_entries = array();
	?>
	<div id="navbar" class="collapse navbar-collapse navbar-right">
      <ul class="nav navbar-nav">
	  	<?php if($user->has_role("games")) { 
			$menu_entries["esar_categories"] = "Catégories Esar";
		?>
    	<li><a href="index.php?o=games">Jeux</a></li>
		<?php } ?>
	  	<?php if($user->has_role("members")) { 
			$menu_entries["membership_types"] = "Types d'adhésion";
			$menu_entries["payment_methods"] = "Méthodes de paiement";
		?>
    	<li><a href="index.php?o=members">Adhérents</a></li>
		<?php } ?>
		<?php if($user->has_role("admin")) { ?>
		<li><a href="index.php?o=users&a=list">Comptes</a></li>
		<?php } ?>
		<?php if(sizeof($menu_entries)) { ?>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
		  	aria-expanded="false">Options <span class="caret"></span></a>
          <ul class="dropdown-menu">
		  <?php while(list($key, $val) = each($menu_entries)) { ?>
            <li><a href="index.php?o=<?=$key?>&a=list"><?=$val?></a></li>
		  <?php } ?>
          </ul>
        </li>
		<?php } ?> 
      </ul>
	  <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php?o=users&a=edit&i=<?=$user->id?>"><span class="glyphicon glyphicon-user"></span> Mon compte</a></li>
        <li><a href="index.php?a=logout"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
      </ul>
		<form class="navbar-form navbar-right">
        <div id="search-all" >
            <input class="typeahead" type="text" placeholder="Recherche...">
        </div>
		</form>
    </div>
	<?php } ?>
  </div>
</nav>
<form action="index.php" method="POST" id="defaultform" name="defaultform" 
	class="form-horizontal" enctype="multipart/form-data">
	<!-- div class="col-sm-9 col-md-10 main" -->
	<div class="container">
<?php
$_REQUEST["a"] = (array_key_exists("a", $_REQUEST)) ? $_REQUEST["a"] : "";
$_REQUEST["i"] = (array_key_exists("i", $_REQUEST)) ? $_REQUEST["i"] : "";
if($user->id == 0) {
	// not authenticated
	$_REQUEST["o"] = "users";
	include("controllers/users.php");
} else {
	if(array_key_exists("o", $_REQUEST) && $_REQUEST["o"] != ""
		&& file_exists("controllers/".$_REQUEST["o"].".php")) {
			
			include("controllers/".$_REQUEST["o"].".php");
	} else {
		$_REQUEST["o"] = "home";
		include("controllers/home.php");
	}
}
?>
	</div>
	<input type="hidden" name="o" id="o" value="<?=$_REQUEST["o"]?>"> 
	<input type="hidden" name="a" id="a" value="<?=$_REQUEST["a"]?>"> 
	<input type="hidden" name="i" id="i" value="<?=$_REQUEST["i"]?>">
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
<script src="js/bootstrap-switch.min.js"></script>
<?php if($user->id != 0) { ?>
<script src="js/functions.js"></script>
<?php } ?>
</body>
</html>
