<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

date_default_timezone_set("Europe/Prague"); //Changing default time zone.

html_start("Calendar", "css/global", "css/calendar", "css/tags/" . $_SESSION["UID"] . "-tags");
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

    if ($_GET["show"] == "day")
    {
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
                $selDay = date("j");
                $selMonth = date("n");
                $selYear = date("Y");
            }
            else
            {
                $selDay = test_input($_GET["day"]);
                $selMonth = test_input($_GET["month"]);
                $selYear = test_input($_GET["year"]);
            }
            // ------ End ------

            // ------ Counting correct date, if the number exceed the correct number ------
            do
            {
                while ($selMonth > 12)
                {
                    $selMonth -= 12;
                    $selYear += 1;
                }
                $numOfDays = cal_days_in_month(CAL_GREGORIAN, $selMonth, $selYear);
                if (($selDay - $numOfDays) > 0)
                {
                    $selDay -= $numOfDays;
                    $selMonth += 1;
                }
            } while ($selDay > $numOfDays || $selMonth > 12);
            // ------ End of correction ------

        }
        else
        {
            $selDay = date("j");
            $selMonth = date("n");
            $selYear = date("Y");
        }
    }
}

$selectedDateString = strtotime("$selDay.$selMonth.$selYear +$moveWeek week");
$selectedDate = date("d.n.Y", $selectedDateString);
$selectedDateDay = date("d", $selectedDateString);
$selectedDateMonth = date("n", $selectedDateString);
$selectedDateYear = date("Y", $selectedDateString);

if ($_GET["show"] == "day")
{
    echo "<script>window.history.pushState('', 'Day', '/calendar.php?show=day&day=$selectedDateDay&month=$selectedDateMonth&year=$selectedDateYear');</script>";
}
?>

<div class="container-fluid" onload="test()">
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
    $redirect = "window.location.href = 'calendar.php?show=day&day=$day&month=$month&year=$year'";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
    $result = getEventsInDay($_SESSION["UID"], $day, $month, $year);
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

    $weekStyle = ($week) ? 'style="height: 70vh;"' : "";
    $now = ($currentDate == $date) ? "current-day" : "";
    echo
    '
        <div class="col calendar-day ' . $now . '" ' . $weekStyle . 'onclick="' . $redirect . '">
            <div class="d-flex flex-column"  style="height: 100%">
                <div class="p-2 row calendar-day-header ' . $now . '">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">';
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $eventName = $row["event_name"];
        $tagColor = $row["tag_color"];
        if ($tagColor == null)
        {
            $tagColor = "#ffff";
        }
        echo '<p style="color: ' . $tagColor . '; text-align: center; margin: 0;">' . $eventName . '</p>';
    }
    echo       '</div>
            </div>
        </div>
    ';
}
function oneDayNotIncluded($day, $month, $year, $week = false)
{
    $redirect = "window.location.href = 'calendar.php?show=day&day=$day&month=$month&year=$year'";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
    $result = getEventsInDay($_SESSION["UID"], $day, $month, $year);
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

    $weekStyle = ($week) ? 'style="height: 70vh;"' : "";
    $now = ($currentDate == $date) ? "current-day" : "";
    echo
    '
        <div class="col calendar-day ' . $now . '" ' . $weekStyle . 'onclick="' . $redirect . '">
            <div class="d-flex flex-column"  style="height: 100%">
                <div class="p-2 row calendar-day-header ' . $now . '" style="background-color: #c300ffa0;">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] .
        '</p>
                </div>
                <div class="p-2 calendar-day-body">';
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $eventName = $row["event_name"];
        $tagColor = $row["tag_color"];
        if ($tagColor == null)
        {
            $tagColor = "#ffff";
        }
        echo '<p style="color: ' . $tagColor . '; text-align: center; margin: 0; height: 100%">' . $eventName . '</p>';
    }
    echo       '</div>
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
    $con = db_connection();
    $strToDate = strtotime("$dayInWeek.$monthNumber.$yearNumber");
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


    $now = ($currentDate == $date) ? "current-day" : "";
    echo
    '
    <div class="col calendar-day ' . $now . '" style="height: 70vh;" id="oneDay">
        <div class="d-flex flex-column" style="height: 100%">
            <div class="m-2 p-2 row calendar-day-header ' . $now . '">
                <p class="col">' . $dayInWeek . '.' . $monthNumber . '.</p>
                <p class="col"></p>
                <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
            </div>
            <div class="container-fluid" style="overflow: auto;">';
    $result = getEventsInDay($_SESSION["UID"], $dayInWeek, $monthNumber, $yearNumber);
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        dayEvent($row["event_from"], $row["event_to"], $row["event_name"], $row["tag_name"], $row["tag_color"]);
    }

    echo
    '<div class="container-fluid row calendarEvent-one-event mb-1">
                    <button type="button" class="calendarEvent-add-event-button" data-bs-toggle="modal" data-bs-target="#AddEventModal">
                        <p>Add Event</p>
                    </button>
                </div>
                <!-- AddEvent Modal -->
                <div class="modal fade" id="AddEventModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- AddEvent Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Event</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- AddEvent Modal body -->
                            <div class="container">
                                <form action="/handlers/AddEvent.php" class="was-validated" method="POST">
                                    <input type="hidden" name="eventDAY" value="' . $dayInWeek . '">
                                    <input type="hidden" name="eventMONTH" value="' . $monthNumber . '">
                                    <input type="hidden" name="eventYEAR" value="' . $yearNumber . '">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" id="eventName" placeholder="Event Name" name="eventName" required>
                                        <label for="eventName" class="form-label">Event Name:</label>
                                    </div>
                                    <div class="form-floating mt-3 mb-3">
                                        <textarea type="text" id="eventDescription" class="form-control" style="height: 35vh"  id="eventDescription" placeholder="Event Description" name="eventDescription" ></textarea>
                                        <label for="eventDescription" class="form-label">Event Description:</label>
                                    </div>
                                    <div class="row">
                                        <div class="col form-floating mt-3 mb-3">
                                            <input type="time" class="form-control" id="from" placeholder="From" name="eventFrom" value="00:00" required>
                                            <label for="from" class="form-label ps-4">From</label>
                                        </div>
                                        <div class="col form-floating mt-3 mb-3">
                                            <input type="time" class="form-control" id="to" placeholder="To" name="eventTo" value="23:59" required>
                                            <label for="to" class="form-label ps-4">To</label>
                                        </div>
                                    </div>
                                    <div class="input-group mt-3 mb-3">
                                        <label class="input-group-text pt-3 pb-3" for="selectTag">Tag</label>
                                        <select onchange="inputTag()" class="form-select pt-3 pb-3" id="selectTag" name="eventTag">
                                            <option value="none" selected>None</option>
                                            <option value="add">Add</option>';
    $query = "SELECT tag_id, tag_name, tag_color FROM calendar_tags WHERE user_id=" . $_SESSION["UID"];
    $result = mysqli_query($con, $query);
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        echo '<option style="color: ' . (($row["tag_color"] == "#ffff") ? "black" : $row["tag_color"]) . ';" value="' . $row["tag_id"] . '">#' . $row["tag_name"] . '</option>';
    }
    echo                               '</select>
                                    </div>
                                    <div id="tagNameDiv" class="col form-floating mt-3 mb-3 showNone">
                                        <input type="text" class="form-control" id="tagName" placeholder="Tag Name" name="tagName">
                                        <label for="tagName" class="form-label ps-4">Tag Name</label>
                                    </div>
                                    <div id="tagDescriptionDiv" class="form-floating mt-3 mb-3 showNone">
                                        <textarea type="text" class="form-control"  id="tagDescription" placeholder="Tag Description" name="tagDescription"></textarea>
                                        <label for="tagDescription" class="form-label">Tag Description:</label>
                                    </div>
                                    <div id="tagColorDiv" class="col form-floating mt-3 mb-3 showNone">
                                        <input type="color" class="form-control" id="tagColor" placeholder="Tag Color" name="tagColor">
                                        <label for="tagColor" class="form-label ps-4">Tag Color</label>
                                    </div>
                                    <button id="loginSubmit" type="submit" class="btn btn-success">Add Event</button>
                                </form>
                                <script type="text/javascript">
                                    function inputTag()
                                    {
                                        let selectOption = document.getElementById("selectTag");
                                        let selectOptionValue = selectOption.options[selectOption.selectedIndex].value;
                                        let eventDescription = document.getElementById("eventDescription");
                                        let tagNameInput = document.getElementById("tagName");
                                        let tagNameDiv = document.getElementById("tagNameDiv");
                                        let tagDescriptionInput = document.getElementById("tagDescription");
                                        let tagDescriptionDiv = document.getElementById("tagDescriptionDiv");
                                        let tagColorInput = document.getElementById("tagColor");
                                        let tagColorDiv = document.getElementById("tagColorDiv");
                                        
                                        console.log("test");

                                        if(selectOptionValue === "add")
                                        {
                                            console.log("add");
                                            eventDescription.style.height = "";
                                            tagNameInput.required = true;
                                            tagColorInput.required = true;
                                            tagNameDiv.classList.remove("showNone");
                                            tagDescriptionDiv.classList.remove("showNone");
                                            tagColorDiv.classList.remove("showNone");
                                        }
                                        else
                                        {
                                            console.log("none");
                                            eventDescription.style.height = "35vh";
                                            tagNameInput.required = false;
                                            tagColorInput.required = false;
                                            tagNameDiv.classList.add("showNone");
                                            tagDescriptionDiv.classList.add("showNone");
                                            tagColorDiv.classList.add("showNone");
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- AddEvent Modal End --->
            </div>
        </div>
    </div>
    ';
}
function dayEvent(string $eventFrom, string $eventTo, string $eventName, $tagName, $tagColor)
{
    if ($tagName == null)
    {
        $tagName = "none";
    }
    if ($tagColor == null)
    {
        $tagColor = "#ffff";
    }
    echo
    '   <div class="container-fluid row calendarEvent-one-event mb-2 ' . $tagName . '" style="cursor: pointer;">
            <div class="col-3" style="height: 5vh;">
                ' . $eventFrom . ' - ' . $eventTo . '
            </div>';

    echo '        <div class="col-3" style="height: 5vh;">
                ' . (($tagName == "none") ? "" : "#" . $tagName) . '
            </div>
            <div class="col-6" style="height: 5vh;">
                ' . $eventName . '
            </div>
        </div>
    ';
}
function getEventsInDayQuery($user_id, $eventDay, $eventMonth, $eventYear)
{
    return "SELECT ce.event_name, ce.event_date, ce.event_from, ce.event_to, ct.tag_name, ct.tag_color
          FROM calendar_event ce LEFT JOIN event_tag et USING (event_id) LEFT JOIN calendar_tags ct USING (tag_id)
          WHERE ce.uid = " . $user_id . " AND ce.event_date = '" . date_to_DB(strtotime("$eventDay.$eventMonth.$eventYear")) . "';";
}
function getEventsInDay($user_id, $eventDay, $eventMonth, $eventYear)
{
    $con = db_connection();
    $result = mysqli_query($con, getEventsInDayQuery($user_id, $eventDay, $eventMonth, $eventYear));
    return $result;
}