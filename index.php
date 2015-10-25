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
include("config/config.php");
include("classes/data.php");
$data = new data();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- link rel="stylesheet" href="css/bootstrap-theme.min.css" -->
	<link rel="stylesheet" href="css/zabuto_calendar.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css" -->
	<link rel="stylesheet" href="css/styles.css">
	<script src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
<?php
$contexts = array("members" => "Adhérents", "games" => "Jeux");
if(!array_key_exists("o", $_REQUEST) || !array_key_exists($_REQUEST["o"], $contexts)) {
    $_REQUEST["o"] = "home";
} 
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
	  	data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">
	  	<img id="logo" src="images/logo-texte.png" alt="phpLudoreve"></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse navbar-right">
      <ul class="nav navbar-nav">
<?php while(list($key, $val) = each($contexts)) { ?>
    	<li><a href="index.php?o=<?=$key?>"><?=$val?></a></li>
<?php } ?>
      </ul>
	  <form class="navbar-form navbar-right">
		<input type="text" class="form-control" placeholder="Recherche...">
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
<form action="index.php" method="post" id="defaultform" name="defaultform" enctype="multipart/form-data">
<div class="container-fluid">
  <div class="row">
	<div class="col-sm-9 col-md-10 main">
<?php
switch($_REQUEST["o"]) {
    case "games";
        include("games/games.php");
    break;

    case "members";
        include("members/members.php");
    break;

    default:
		//header("Location: ./accueil/index.php");
        ?>
        //include("accueil/index.php");
        <?php
    break;
}
?>
        <input type="hidden" name="o" id="o" value="<?=$_REQUEST["o"]?>"> 
        <input type="hidden" name="a" id="a" value="<?=(array_key_exists("a", $_REQUEST)) ? $_REQUEST["a"] : ""?>"> 
        <input type="hidden" name="i" id="i" value="<?=(array_key_exists("i", $_REQUEST)) ? $_REQUEST["i"] : ""?>">
	<div>

	<div class="col-sm-3 col-sm-offset-9 col-md-2  col-md-offset-10 sidebar">
	  <ul class="nav nav-sidebar">
	  <div id="my-calendar"></div>
<?php
//include("helpers/calendar.php");
// FIXME include("helpers/history.php");
?>
	  </ul>
	</div>
  </div>
</div>  
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
<script src="js/zabuto_calendar.min.js"></script>
<script src="js/functions.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $("#my-calendar").zabuto_calendar({
			language: "fr",
			today: true,
		});
    });
	/*
	TODO : Display calendar events via ajax
	See documentation at https://github.com/zabuto/calendar
	*/
</script>
</body>
</html>
