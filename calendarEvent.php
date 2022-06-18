<?php
include_once 'functions/globalFunctions.php';
session_start();

html_start("Event", "css/global", "css/calendar");
nav();

// ------ ALREADY MOVED ------
$daysOfWeekCZ =
    [
        1 => "Po",
        "Út",
        "St",
        "Čt",
        "Pá",
        "So",
        "Ne"
    ];
$daysOfWeekCzech =
    [
        1 => "Pondělí",
        "Úterý",
        "Středa",
        "Čtvrtek",
        "Pátek",
        "Sobota",
        "Neděle"
    ];
if (isset($_GET["day"]) && isset($_GET["month"]) && isset($_GET["year"]))
{
    /*
        // ------ If empty, it will use current date ------
        if ($_GET["day"] != "" || $_GET["month"] != "" || $_GET["year"] != "")
        {
            $day = test_input($_GET["day"]);
            $month = test_input($_GET["month"]);
            $year = test_input($_GET["year"]);
        }
        else
        {
            $day = date("j");
            $month = date("n");
            $year = date("Y");
        }
        // ------ End ------
    */

    $dayInput = test_input($_GET["day"]);
    $monthInput = test_input($_GET["month"]);
    $yearInput = test_input($_GET["year"]);

    // ------ If not a number, it will use current date ------
    if (!is_numeric($dayInput) || !is_numeric($monthInput) || !is_numeric($yearInput))
    {
        $day = date("j");
        $month = date("n");
        $year = date("Y");
    }
    else
    {
        $day = test_input($_GET["day"]);
        $month = test_input($_GET["month"]);
        $year = test_input($_GET["year"]);
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

}
else
{
    $day = date("j");
    $month = date("n");
    $year = date("Y");
}

$date = strtotime("$day.$month.$year");
$dateDay = date("l", $date);
$selectedDate = date("j.n.Y", $date);
// ------ ALREADY MOVED ------

banner($dateDay . " " . $selectedDate);

?>

<div class="container-fluid" style="height: 70vh; background-color: red;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 calendar-side-nav" style="background-color: orange; height: 70vh;">

            </div>
            <div class="col-10" style="background-color: yellow; height: 70vh; color: red;">

            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();