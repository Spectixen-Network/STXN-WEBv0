<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

date_default_timezone_set("Europe/Prague"); //Changing default time zone.

html_start("Calendar", "css/global", "css/calendar");
nav();
//banner("Calendar");

if (!isset($_GET["show"]))
{
    $_GET["show"] = "month";
}

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
$monthsNamesCZ =
    [
        1 => "Led",
        "Úno",
        "Bře",
        "Dub",
        "Kvě",
        "Čvn",
        "Čvc",
        "Srp",
        "Zář",
        "Říj",
        "Lis",
        "Pro"
    ];
$monthsNamesCzech =
    [
        1 => "Leden",
        "Únor",
        "Březen",
        "Duben",
        "Květen",
        "Červen",
        "Červenec",
        "Srpen",
        "Září",
        "Říjen",
        "Listopad",
        "Prosinec"
    ];
$currentDay = date("d");
$currentWeek = date("W");
$currentMonth = date("n");
$currentYear = date("Y");
$currentMoveWeek = 0;

if (count($_POST) > 0)
{
    $selDay = $_POST["DAY"];
    $selMonth = $_POST["MONTH"];
    $selYear = $_POST["YEAR"];
    $moveWeek = $_POST["moveWeek"];
}
else
{
    $selDay = $currentDay;
    $selMonth = $currentMonth;
    $selYear = $currentYear;
    $moveWeek = $currentMoveWeek;
}

$selectedDateString = strtotime("$selDay.$selMonth.$selYear +$moveWeek week");
$selectedDate = date("d.n.Y", $selectedDateString);
$selectedDateDay = date("d", $selectedDateString);
$selectedDateMonth = date("n", $selectedDateString);
$selectedDateYear = date("Y", $selectedDateString);
?>

<div class="container-fluid" onload="setScroll()">
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
        <div class="container-fluid calendar-navigation">
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div onclick="today();" title="<?php echo $currentDay . "." . $currentMonth . "." . $currentYear ?>" class="col-3 calendar-navigation-today" style="text-align: center;">
                            Today
                        </div>
                        <div class="col-3 row">
                            <span onclick="previous();" title="Previous <?php
                                                                        if (isset($_GET["show"]))
                                                                        {
                                                                            if (strtolower(test_input($_GET["show"])) == "month")
                                                                            {
                                                                                echo "month";
                                                                            }
                                                                            elseif (strtolower(test_input($_GET["show"])) == "week")
                                                                            {
                                                                                echo "week";
                                                                            }
                                                                            elseif (strtolower(test_input($_GET["show"])) == "day")
                                                                            {
                                                                                echo "day";
                                                                            }
                                                                            else
                                                                            {
                                                                                echo "month";
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "month";
                                                                        }
                                                                        ?>" class="col-6 d-flex justify-content-center calendar-navigation-arrow">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                            <span onclick="next();" title="Next <?php
                                                                if (isset($_GET["show"]))
                                                                {
                                                                    if (strtolower(test_input($_GET["show"])) == "month")
                                                                    {
                                                                        echo "month";
                                                                    }
                                                                    elseif (strtolower(test_input($_GET["show"])) == "week")
                                                                    {
                                                                        echo "week";
                                                                    }
                                                                    elseif (strtolower(test_input($_GET["show"])) == "day")
                                                                    {
                                                                        echo "day";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "month";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo "month";
                                                                }
                                                                ?>" class="col-6 d-flex justify-content-center calendar-navigation-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                        <div class="col-6" style="text-align: center; padding: 0; cursor: default;">
                            <?php
                            if (isset($_GET["show"]))
                            {
                                if (strtolower(test_input($_GET["show"])) == "month")
                                {
                                    echo date("F", $selectedDateString) . " " . date("Y", $selectedDateString);
                                }
                                elseif (strtolower(test_input($_GET["show"])) == "week")
                                {
                                    echo date("F", $selectedDateString) . " " . date("Y", $selectedDateString) . " " . date("W", $selectedDateString) . ". Week";
                                }
                                elseif (strtolower(test_input($_GET["show"])) == "day")
                                {
                                    echo date("j", $selectedDateString) . ". " . date("F", $selectedDateString) . " " . date("Y", $selectedDateString) . " " . date("W", $selectedDateString) . ". Week";
                                }
                                else
                                {
                                    echo date("F", $selectedDateString) . " " . date("Y", $selectedDateString);
                                }
                            }
                            else
                            {
                                echo date("F", $selectedDateString) . " " . date("Y", $selectedDateString);
                            }
                            ?>
                        </div>
                    </div>
                    <form method="POST" id="dateForm">
                        <input type="hidden" name="selectedView" id="selectedView" value="<?php echo $_GET["show"]; ?>">
                        <input type="hidden" name="DAY" id="DAY" value="<?php echo $selectedDateDay; ?>">
                        <input type="hidden" name="moveWeek" id="moveWeek" value="<?php echo $moveWeek; ?>">
                        <input type="hidden" name="MONTH" id="MONTH" value="<?php echo $selectedDateMonth; ?>">
                        <input type="hidden" name="YEAR" id="YEAR" value="<?php echo $selectedDateYear; ?>">
                    </form>
                    <script>
                    function next() {
                        let form = document.getElementById('dateForm');
                        let formSelectedView = document.getElementById('selectedView');
                        let formDay = document.getElementById('DAY');
                        let Day = parseInt(formDay.value, 10);
                        let formMoveWeek = document.getElementById('moveWeek');
                        let moveWeek = parseInt(formMoveWeek.value, 10);
                        let formMonth = document.getElementById('MONTH');
                        let Month = parseInt(formMonth.value, 10);
                        let formYear = document.getElementById('YEAR');
                        let Year = parseInt(formYear.value, 10);

                        if (formSelectedView.value.toLowerCase() == "month") {
                            if (Month + 1 > 12) {
                                Month = 1;
                                Year += 1;
                                formMonth.value = Month;
                                formYear.value = Year;
                            } else {
                                Month += 1;
                                formMonth.value = Month;
                            }
                        } else if (formSelectedView.value.toLowerCase() == "week") {
                            moveWeek = 1;
                            formMoveWeek.value = moveWeek;
                        } else if (formSelectedView.value.toLowerCase() == "day") {
                            if (Day + 1 > getDays(Month, Year)) {
                                Day = 1;
                                if (Month + 1 > 12) {
                                    Month = 1;
                                    Year += 1;
                                    formMonth.value = Month;
                                    formYear.value = Year;
                                } else {
                                    Month += 1;
                                    formMonth.value = Month;
                                }
                                formDay.value = Day;
                            } else {
                                Day += 1;
                                formDay.value = Day;
                            }
                        }
                        //console.log(formDay.value + " " +formMonth.value +" " + formYear.value);
                        form.submit();
                    }

                    function previous() {
                        let form = document.getElementById('dateForm');
                        let formSelectedView = document.getElementById('selectedView');
                        let formDay = document.getElementById('DAY');
                        let Day = parseInt(formDay.value, 10);
                        let formMoveWeek = document.getElementById('moveWeek');
                        let moveWeek = parseInt(formMoveWeek.value, 10);
                        let formMonth = document.getElementById('MONTH');
                        let Month = parseInt(formMonth.value, 10);
                        let formYear = document.getElementById('YEAR');
                        let Year = parseInt(formYear.value, 10);

                        if (formSelectedView.value.toLowerCase() == "month") {
                            if ((Month - 1) == 0) {
                                Month = 12;
                                Year -= 1;
                                formMonth.value = Month;
                                formYear.value = Year;
                            } else {
                                Month -= 1;
                                formMonth.value = Month;
                            }
                        } else if (formSelectedView.value.toLowerCase() == "week") {
                            moveWeek = -1;
                            formMoveWeek.value = moveWeek;
                        } else if (formSelectedView.value.toLowerCase() == "day") {
                            if ((Day - 1) == 0) {
                                if ((Month - 1) == 0) {
                                    Month = 12;
                                    Year -= 1;
                                    Day = getDays(Month, Year);
                                    formMonth.value = Month;
                                    formYear.value = Year;
                                } else {
                                    Month -= 1;
                                    Day = getDays(Month, Year);
                                    formMonth.value = Month;
                                }
                                formDay.value = Day;
                            } else {
                                Day -= 1;
                                formDay.value = Day;
                            }
                        }
                        //console.log(formDay.value + " " +formMonth.value +" " + formYear.value);
                        form.submit();
                    }

                    function today() {
                        let form = document.getElementById('dateForm');
                        let formDay = document.getElementById('DAY');
                        let formMoveWeek = document.getElementById('moveWeek');
                        let formMonth = document.getElementById('MONTH');
                        let formYear = document.getElementById('YEAR');
                        let formToday = document.getElementById('TODAY');

                        let dateOfToday = new Date();
                        let Day = dateOfToday.getDate();
                        let moveWeek = 0;
                        let Month = dateOfToday.getMonth() + 1;
                        let Year = dateOfToday.getFullYear();

                        formDay.value = Day;
                        formMoveWeek.value = moveWeek;
                        formMonth.value = Month;
                        formYear.value = Year;

                        form.submit();
                    }
                    const getDays = (month, year) => {
                        return new Date(year, month, 0).getDate();
                    };
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 calendar-side-nav ">

            </div>
            <div class="col-10 calendar-body">
                <?php
                if (isset($_GET["show"]))
                {
                    if (strtolower(test_input($_GET["show"])) == "month")
                    {
                        Month($selectedDateMonth, $selectedDateYear);
                    }
                    elseif (strtolower(test_input($_GET["show"])) == "week")
                    {
                        Week($selectedDateDay, $selectedDateMonth, $selectedDateYear);
                    }
                    elseif (strtolower(test_input($_GET["show"])) == "day")
                    {
                        Day($selectedDateDay, $selectedDateMonth, $selectedDateYear);
                    }
                    else
                    {
                        Month($selectedDateMonth, $selectedDateYear);
                    }
                }
                else
                {
                    Month($selectedDateMonth, $selectedDateYear);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//footer();
html_end();

function oneDay($day, $month, $year, $week = false)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
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
        <div class="col calendar-day ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" ';
    if ($week)
    {
        echo 'style="height: 70vh;"';
    }
    echo 'onclick="' . $redirect . '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">
                    <p style="text-align: center; margin: 0;">
                        
                    </p>
                </div>
            </div>
        </div>
    ';
}
function oneDayNotIncluded($day, $month, $year, $week = false)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
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
        <div class="col calendar-day ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" ';
    if ($week)
    {
        echo 'style="height: 70vh;"';
    }
    echo ' onclick="' . $redirect .
        '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" style="background-color: #c300ffa0;">
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
function Month($monthNumber, $yearNumber)
{
    $firstDayDate = strtotime("1.$monthNumber.$yearNumber");
    $numOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $yearNumber);
    $lastDayDate = strtotime("$numOfDaysInMonth.$monthNumber.$yearNumber");
    $firstDayOrderNumber = date("N", $firstDayDate);
    $lastDayOrderNumber = date("N", $lastDayDate);
    $daysBefore = $firstDayOrderNumber - 1;
    $daysAfter = 7 - $lastDayOrderNumber;
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
function Week($dayInWeek, $monthNumber, $yearNumber)
{
    $dayDate = strtotime("$dayInWeek.$monthNumber.$yearNumber");
    $numOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $yearNumber);
    if ($monthNumber == 1)
    {
        $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, 12, $yearNumber - 1);
    }
    else
    {
        $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthNumber - 1, $yearNumber);
    }
    $dayOrderNumber = date("N", $dayDate);
    $daysBefore = $dayOrderNumber - 1;
    $daysAfter = 7 - $dayOrderNumber;


    echo '<div class="row" style="height: 70vh">';
    // ------ Days Before ------
    for ($b = 0; $b < $daysBefore; $b++)
    {
        if ($monthNumber == 1)
        {
            if (($dayInWeek - ($daysBefore - $b)) <= 0)
            {
                oneDay($numOfDaysInMonthBefore + $dayInWeek - ($daysBefore - $b), 12, $yearNumber - 1, true);
            }
            else
            {
                oneDay($dayInWeek - ($daysBefore - $b), $monthNumber, $yearNumber, true);
            }
        }
        else
        {
            if (($dayInWeek - ($daysBefore - $b)) <= 0)
            {
                oneDay($numOfDaysInMonthBefore + $dayInWeek - ($daysBefore - $b), $monthNumber - 1, $yearNumber, true);
            }
            else
            {
                oneDay($dayInWeek - ($daysBefore - $b), $monthNumber, $yearNumber, true);
            }
        }
    }
    // ------ End Days Before ------
    oneDay($dayInWeek, $monthNumber, $yearNumber, true);
    // ------ Days After ------
    for ($a = 1; $a <= $daysAfter; $a++)
    {
        if ($monthNumber == 12)
            if (($dayInWeek + $a) > $numOfDaysInMonth)
            {
                oneDay($dayInWeek + $a - $numOfDaysInMonth, 1, $yearNumber + 1, true);
            }
            else
            {
                oneDay($dayInWeek + $a, $monthNumber, $yearNumber, true);
            }
        else
        {
            if (($dayInWeek + $a) > $numOfDaysInMonth)
            {
                oneDay($dayInWeek + $a - $numOfDaysInMonth, $monthNumber + 1, $yearNumber, true);
            }
            else
            {
                oneDay($dayInWeek + $a, $monthNumber, $yearNumber, true);
            }
        }
    }
    // ------ End Days After ------
    echo '</div>';
};
function Day($dayInWeek, $monthNumber, $yearNumber)
{
    echo '<div class="row" style="height: 70vh">';
    oneDay($dayInWeek, $monthNumber, $yearNumber, true);
    echo '</div>';
};