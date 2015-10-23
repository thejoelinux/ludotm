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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/functions.js"></script>

    </head>
<body>
<div id="header_zone">
    <div id="menu_zone">
<?php
$contexts = array("home", "members", "games");
if(!array_key_exists("o", $_REQUEST)) {
    $_REQUEST["o"] = "home";
} else {
    if(!in_array($_REQUEST["o"], $contexts)) {
        echo '{"message":"Error : '.$_REQUEST["o"].' : no such context."}';
        exit();
    }    
}
?>
    <a href="javascript:set_value('o', '<?=$val?>');set_value('a','');set_value('i','');document.defaultform.submit()"><?=$val?></a>
<?php
while(list($key, $val) = each($contexts)) { ?>
    :: <a href="javascript:set_value('o', '<?=$val?>');set_value('a','');set_value('i','');document.defaultform.submit()"><?=$val?></a>
<?php } ?>
    </div>
</div>
<?php
// compute date
include("helpers/date.php");
?>
<div id="middle_zone">
    <div id="main_view">
    <form action="index.php" method="post" id="defaultform" name="defaultform">

<?php

switch($_REQUEST["o"]) {
    case "games";
        include("games/games.php");
    break;

    case "members";
        include("members/members.php");
    break;

    default:
        ?>
        //include("accueil/index.php");
        <?php
    break;
}

//header("Location: ./accueil/index.php");
?>
        <input type="hidden" name="o" id="o" value="<?=$_REQUEST["o"]?>"> 
        <input type="hidden" name="a" id="a" value="<?=(array_key_exists("a", $_REQUEST)) ? $_REQUEST["a"] : ""?>"> 
        <input type="hidden" name="i" id="i" value="<?=(array_key_exists("i", $_REQUEST)) ? $_REQUEST["i"] : ""?>">
    </div>
    <div id="toolbox">
<?php
include("helpers/calendar.php");
// FIXME include("helpers/history.php");
?>
    </div>
    </form>
</div>
<div id="footer_zone">
<?php if($debug) { ?>
<pre>
REQUEST :
<?php print_r($_REQUEST) ?>
SESSION :
<?php print_r($_SESSION) ?>
</pre>
<?php } ?>
</div>

</body>
</html>
