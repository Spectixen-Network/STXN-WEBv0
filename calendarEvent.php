<?php
include_once 'functions/globalFunctions.php';
session_start();

html_start("Event", "css/global", "css/calendar");
nav();

$daysOfWeekCZ =
    [
        1 => "Po",
        "Út",
        "St",
        "Čt",
        "Pa",
        "So",
        "Ne"
    ];

if (isset($_GET["day"]) && isset($_GET["month"]) && isset($_GET["year"]))
{
    // ------ If empty, it will use current date ------
    if ($_GET["day"] == "" || $_GET["month"] == "" || $_GET["year"] == "")
    {
        goto notStated;
    }
    // ------ End ------

    $day = test_input($_GET["day"]);
    $month = test_input($_GET["month"]);
    $year = test_input($_GET["year"]);

    // ------ If not a number, it will use current date ------
    if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year))
    {
        goto notStated;
    }
    // ------ End ------

    // ------ Counting correct date, if the number exceed the correct number ------
    do
    {
        while ($month > 12)
        {
            $month -= 12;
            $year += 1;
        }
        $numOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if (($day - $numOfDays) > 0)
        {
            $day -= $numOfDays;
            $month += 1;
        }
    } while ($day > $numOfDays || $month > 12);
    // ------ End of correction ------

    $date = strtotime($day . "." . $month . "." . $year);
    $dateDay = date("l", $date);
    $selectedDate = date("d.m.Y", $date);
    banner($dateDay . " " . $selectedDate);
}
else
{
    notStated:
    banner(date("l") . " " . date("d.m.Y"));
}



footer();
html_end();