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
    <div class="calendar-nav" style="height: 5vh; background-color: Blue; margin-bottom: 1vh;">

    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-2" style="background-color: red; height: 70vh;">

            </div>
            <div class="col-10" style="background-color: blue; height: 70vh;">
                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh;">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">1</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">2</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>

                    <div class="col" style="background-color: green; height: 14vh">
                        <div class="d-flex flex-column">
                            <div class="p-2" style="background-color: purple;">
                                <p style="text-align: center; margin: 0;">3</p>
                            </div>
                            <div class="p-2" style="background-color: black;">
                                <p style="text-align: center;">test<br>test</p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: pink; height: 14vh">;

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>

                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                    <div class="col" style="background-color: yellow; height: 14vh">

                    </div>
                    <div class="col" style="background-color: pink; height: 14vh">

                    </div>
                </div>
                <div class="row">
                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                    <div class="col" style="background-color: orange; height: 14vh">

                    </div>

                    <div class="col" style="background-color: green; height: 14vh">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();

function oneDay($numberOfDay)
{
    echo
    '
        <div class="col" style="background-color: green; height: 14vh; border: solid black 1px;">
            <div class="d-flex flex-column">
                <div class="p-2" style="background-color: purple;">
                    <p style="text-align: center; margin: 0;">' . $numberOfDay . '</p>
                </div>
                <div class="p-2" style="background-color: black;">
                    <p style="text-align: center; margin: 0;">test<br>test</p>
                </div>
            </div>
        </div>
    ';
}
function oneWeek($numberOfFirstDay)
{
    echo '<div class="row">';
    for ($i = $numberOfFirstDay; $i < $numberOfFirstDay + 7; $i++)
    {
        oneDay($i);
    }
    echo '</div>';
}
function oneMonth($monthNumber, $year)
{
    $numOfDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
    $numOfWeeks = round($numOfDays / 7, 0);
    oneWeek(1);
    oneWeek(8);
    oneWeek(15);
    oneWeek(22);
    echo '<div class="row">';
    for ($i = 1; $i <= $numOfDays - 7 * $numOfWeeks; $i++)
    {
        oneDay(28 + $i);
    }
    echo '</div>';
}