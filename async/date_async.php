<?php
// display a calendar in async mode to select a date in the date field
ini_set("include_path", ini_get("include_path").":..");
include("classes/calendar.php");
include("helpers/date.php");

$cal = new calendar ($year, $month);
?>
<div class="calendar_title">
<a href="javascript:modif_date('<?=$previous_year."-".sprintf("%02d", $previous_month)."-".date("t", mktime(0,0,0,$previous_month,1,$previous_year))?>','<?=$_POST["div"]?>','<?=$_POST["field"]?>');">&lt;&lt;</a>&nbsp;&nbsp; 
<?=$cal->getFullMonthName()." ".$cal->getYear()?>&nbsp;&nbsp; 
<a href="javascript:modif_date('<?=$next_year."-".sprintf("%02d", $next_month)."-01"?>','<?=$_POST["div"]?>','<?=$_POST["field"]?>')">&gt;&gt;</a>
</div>
<?=$cal->display();?>
