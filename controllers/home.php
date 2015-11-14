<?php
$render = "home/index";

// fetch the N oldest loans order by due date ASC
$loans = array();
Loan::fetch_all($loans, 0);

// fetch the N newest members order by date DESC
$members = array();
Member::fetch_last($members);

// fetch the dates of birthdays for the calendar...


// view part
include("views/".$render.".php");
?>
