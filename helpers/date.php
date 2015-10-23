<?php
// $Id$
// process the date, compute previous and next days
// date should be posted/gettted in YYYY-MM-DD format
if(
    (array_key_exists("date", $_REQUEST) && 
        preg_match('/(?P<year>\d+)-(?P<month>\d+)-(?P<day>\d+)/', $_REQUEST["date"], $m) &&
        $date = $_REQUEST["date"])
    ||
    (array_key_exists("date", $_SESSION) && 
        preg_match('/(?P<year>\d+)-(?P<month>\d+)-(?P<day>\d+)/', $_SESSION["date"], $m) &&
        $date = $_SESSION["date"])
    ) {
    $year = $m["year"];
    $month = $m["month"];
    $day = $m["day"];
} else {
    $date = date("Y-m-d");
    $year = date("Y");
    $month = date("m");
    $day = date("d");
}
$_SESSION["date"] = $date;
$yersteday = date("Y-m-d", mktime(0, 0, 0, $month, $day - 1, $year));
$tomorrow = date("Y-m-d", mktime(0, 0, 0, $month, $day + 1, $year));
$today = ($date == date("Y-m-d"));

if($month == 1) {
        $previous_month = 12;
        $previous_year = $year - 1;
        $next_month = 2;
        $next_year = $year;
} else {
        if($month == 12) {
                $next_month = 1;
                $next_year = $year + 1;
        }
        else {
                $next_month = $month + 1;
                $next_year = $year;
        }
        $previous_month = $month - 1;
        $previous_year = $year;
}

$week_number = date("W", mktime(0, 0, 0, $month, $day, $year));
