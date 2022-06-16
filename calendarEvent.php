<?php
include_once 'functions/globalFunctions.php';
session_start();

html_start("Event", "css/style");
nav();

if (isset($_GET["day"]) && isset($_GET["month"]) && isset($_GET["year"]))
{
    $day = $_GET["day"];
    $month = $_GET["month"];
    $year = $_GET["year"];
    banner($day . "." . $month . "." . $year);
}
else
{
    banner(date("d.m.Y"));
}



footer();
html_end();