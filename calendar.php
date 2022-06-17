<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

date_default_timezone_set("Europe/Prague"); //Changing default time zone.

html_start("Calendar", "css/style");
nav();
banner("Calendar");

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
?>

<div class="container-fluid">
    <div class="container-fluid calendar-nav" style="margin-bottom: 1vh;">
        <div class="row d-flex justify-content-center">
            <div class="col-4 calendar-nav-button">
                <a href="?show=month">
                    Month
                </a>
            </div>
            <div class="col-4 calendar-nav-button">
                <a href="?show=week">
                    Week
                </a>
            </div>
            <div class="col-4 calendar-nav-button">
                <a href="?show=day">
                    Day
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-2" style="background-color: red; ">

            </div>
            <div class="col-10" style="background-color: blue; ">
                <?php
                emptyDay();
                oneDay(17, 6, 2022);
                oneMonth(6, 2022);
                ?>

            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();

function oneDay($numberOfDay, $month, $year)
{
    $strToDate = strtotime("$numberOfDay.$month.$year");
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


    echo
    '
        <div class="col calendar-day">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header">
                    <p class="col">' . $numberOfDay . '</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2" style="background-color: black;">
                    <p style="text-align: center; margin: 0;">test<br>test</p>
                </div>
            </div>
        </div>
    ';
}
function emptyDay()
{
    echo
    '
        <div class="col calendar-day">
            <div class="d-flex flex-column">
                <div class="p-2 calendar-day-header">
                    <p></p>
                </div>
                <div class="p-2">
                </div>
            </div>
        </div>
    ';
}
function oneWeek($numberOfFirstDay, $month, $year)
{

    echo '<div class="row">';
    for ($i = $numberOfFirstDay; $i < $numberOfFirstDay + 7; $i++) {
        oneDay($i, $month, $year);
    }
    echo '</div>';
}
function oneMonth($monthNumber, $year)
{
    $numOfDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
    $numOfWeeks = round($numOfDays / 7, 0);
    oneWeek(1, $monthNumber, $year);
    oneWeek(8, $monthNumber, $year);
    oneWeek(15, $monthNumber, $year);
    oneWeek(22, $monthNumber, $year);
    echo '<div class="row">';
    for ($i = 1; $i <= $numOfDays - 7 * $numOfWeeks; $i++) {
        oneDay(28 + $i, $monthNumber, $year);
    }
    echo '</div>';
}