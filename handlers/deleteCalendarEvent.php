<?php
session_start();
include_once '../functions/globalFunctions.php';

$eventID = $_POST["eventID"];
$day = $_POST["eventDAY"];
$month = $_POST["eventMONTH"];
$year = $_POST["eventYEAR"];
if (hasEventTagEntry($eventID))
{
    deleteFromEventTag($eventID);
}
deleteFromCalendarEvent($eventID);
header("Location: /calendar.php?show=day&day=$day&month=$month&year=$year");
die();

function deleteFromEventTagQuery($event_id)
{
    return "DELETE FROM event_tag WHERE event_id='" . $event_id . "';";
}
function deleteFromEventTag($event_id)
{
    $con = db_connection();
    mysqli_query($con, deleteFromEventTagQuery($event_id));
}
function deleteFromCalendarEventQuery($event_id)
{
    return "DELETE FROM calendar_event WHERE event_id='" . $event_id . "';";
}
function deleteFromCalendarEvent($event_id)
{
    $con = db_connection();
    mysqli_query($con, deleteFromCalendarEventQuery($event_id));
}
function hasEventTagEntryQuery($event_id)
{
    return "SELECT * from event_tag WHERE event_id='" . $event_id . "';";
}
function hasEventTagEntry($event_id)
{
    $con = db_connection();
    if (mysqli_num_rows(mysqli_query($con, hasEventTagEntryQuery($event_id))) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}