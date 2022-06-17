<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

date_default_timezone_set("Europe/Prague"); //Changing default time zone.

html_start("Calendar", "css/global", "css/calendar");
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
            <div class="col-2 calendar-side-nav ">

            </div>
            <div class="col-10 calendar-body">
                <?php
                Month(2, 2022);
                ?>
            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();

function oneDay($day, $month, $year)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
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
        <div class="col calendar-day" onclick="' . $redirect . '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">
                    <p style="text-align: center; margin: 0;">
                        test<br>test
                    </p>
                </div>
            </div>
        </div>
    ';
}
function oneDayNotIncluded($day, $month, $year)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
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
        <div class="col calendar-day" onclick="' . $redirect . '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header" style="background-color: #c300ffa0;">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">
                    <p style="text-align: center; margin: 0;">
                        test<br>test
                    </p>
                </div>
            </div>
        </div>
    ';
}
function oneWeek($numberOfFirstDay, $month, $year)
{

    echo '<div class="row">';
    for ($i = $numberOfFirstDay; $i < $numberOfFirstDay + 7; $i++)
    {
        oneDay($i, $month, $year);
    }
    echo '</div>';
}
function Month($monthNumber, $yearNumber)
{
    $firstDayDate = strtotime("1.$monthNumber.$yearNumber");
    $numOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $yearNumber);
    $lastDayDate = strtotime("$numOfDaysInMonth.$monthNumber.$yearNumber");
    $firstDayOrderNumber = date("N", $firstDayDate);
    $lastDayOrferNumber = date("N", $lastDayDate);
    $daysBefore = $firstDayOrderNumber - 1;
    $daysAfter = 7 - $lastDayOrferNumber;
    if ($daysBefore != 0)
    {
        if ($monthNumber == 1)
        {
            $yearBefore = $yearNumber - 1;
            $monthBefore = 12;
            $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthBefore, $yearBefore);
        }
        else
        {
            $yearBefore = $yearNumber;
            $monthBefore = $monthNumber - 1;
            $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthBefore, $yearBefore);
        }
    }
    if ($daysAfter != 0)
    {
        if ($monthNumber == 12)
        {
            $yearAfter = $yearNumber + 1;
            $monthAfter = 1;
            $numOfDaysInMonthAfter = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $yearAfter);
        }
        else
        {
            $yearAfter = $yearNumber;
            $monthAfter = $monthNumber + 1;
            $numOfDaysInMonthAfter = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $yearAfter);
        }
    }


    // ------ Printing whole month ------
    for ($i = 1, $j = 0, $beforeDone = 0; $i <= $numOfDaysInMonth; $i++)
    {
        if ($j == 7)
        {
            $j = 0;
        }
        if ($j == 0)
        {
            echo '<div class="row">';
        }

        // ------ Days Before ------
        for ($b = 1; $b <= $daysBefore && $beforeDone == 0; $b++)
        {
            oneDayNotIncluded($numOfDaysInMonthBefore - ($daysBefore - $b), $monthBefore, $yearBefore);
            $j++;
        }
        $beforeDone = 1;
        // ------ End Days Before ------

        oneDay($i, $monthNumber, $yearNumber);
        $j++;

        // ------ Days After ------
        for ($a = 1; $a <= $daysAfter && $i == $numOfDaysInMonth; $a++)
        {
            oneDayNotIncluded($a, $monthAfter, $yearAfter);
            $j++;
        }
        // ------ End Days After ------

        if ($j == 7)
        {
            echo '</div>';
        }
    }
    // ------ End of printing ------
}