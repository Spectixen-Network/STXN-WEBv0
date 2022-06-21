<?php
session_start();
include_once '../functions/globalFunctions.php';

if (count($_POST) > 0)
{
    $eventDay = $_POST["eventDAY"];
    $eventMonth = $_POST["eventMONTH"];
    $eventYear = $_POST["eventYEAR"];
    $eventName = test_input($_POST["eventName"]);
    $eventDescription = test_input($_POST["eventDescription"]);
    $eventFrom = test_input($_POST["eventFrom"]);
    $eventTo = test_input($_POST["eventTo"]);
    $eventTag = test_input($_POST["eventTag"]);

    insertIntoCalendarEvent($eventName, $eventDescription, $eventFrom, $eventTo, $eventDay, $eventMonth, $eventYear, $_SESSION["UID"]);
    if ($eventTag != "none")
    {
        if ($eventTag == "add")
        {
            $tagName = test_input($_POST["tagName"]);
            $tagDescription = test_input($_POST["tagDescription"]);
            $tagColor = $_POST["tagColor"];

            insertIntoCalendarTags($_SESSION["UID"], $tagName, $tagDescription, $tagColor);
            $tagID = getTagID($_SESSION["UID"], $tagName);
            insertIntoEventTag($tagID, getEventID($eventName, $_SESSION["UID"]), $_SESSION["UID"]);

            $cssFile = fopen("../css/tags/" . $_SESSION["UID"] . "-tags.css", "a");
            $cssContent = "
            .$tagName {
                background-color: " . $tagColor . "33;
                color: $tagColor;
            }
            .$tagName:hover {
                background-color: " . $tagColor . "66;
            }
            ";
            fwrite($cssFile, $cssContent);
            fclose($cssFile);
        }
        else
        {
            insertIntoEventTag($eventTag, getEventID($eventName, $_SESSION["UID"]), $_SESSION["UID"]);
        }
    }

    header("Location: /calendar.php?show=day&day=$eventDay&month=$eventMonth&year=$eventYear");
    die();
}

function insertIntoCalendarEventQuery($eventName, $eventDescription, $eventFrom, $eventTo, $eventDay, $eventMonth, $eventYear, $user_id)
{
    return "INSERT INTO calendar_event(uid ,event_name, event_description, event_date, event_from, event_to) VALUE('$user_id', '$eventName', '$eventDescription', '" . date_to_DB(strtotime("$eventDay.$eventMonth.$eventYear")) . "', '$eventFrom', '$eventTo');";
}
function insertIntoCalendarEvent($eventName, $eventDescription, $eventFrom, $eventTo, $eventDay, $eventMonth, $eventYear, $user_id)
{
    $con = db_connection();
    mysqli_query($con, insertIntoCalendarEventQuery($eventName, $eventDescription, $eventFrom, $eventTo, $eventDay, $eventMonth, $eventYear, $user_id));
}
function insertIntoEventTagQuery($user_id, $tagID, $eventID)
{
    return "INSERT INTO event_tag(uid, tag_id, event_id) VALUES ('$user_id', '$tagID', '$eventID')";
}
function insertIntoEventTag($tagID, $eventID, $user_id)
{
    $con = db_connection();
    mysqli_query($con, insertIntoEventTagQuery($user_id, $tagID, $eventID));
}
function getEventIDQuery($eventName, $user_id)
{
    return "SELECT event_id FROM calendar_event WHERE uid=$user_id AND event_name='$eventName';";
}
function getEventID($eventName, $user_id)
{
    $con = db_connection();
    $result = mysqli_query($con, getEventIDQuery($eventName, $user_id));
    return mysqli_fetch_row($result)[0];
}
function insertIntoCalendarTagsQuery($userID, $tagName, $tagDescription, $tagColor)
{
    return "INSERT INTO calendar_tags(user_id, tag_name, tag_description, tag_color) VALUE ('$userID', '$tagName', '$tagDescription', '$tagColor');";
}
function insertIntoCalendarTags($userID, $tagName, $tagDescription, $tagColor)
{
    $con = db_connection();
    mysqli_query($con, insertIntoCalendarTagsQuery($userID, $tagName, $tagDescription, $tagColor));
}
function getTagIDQuery($user_id, $tagName)
{
    return "SELECT tag_id FROM calendar_tags WHERE user_id=$user_id AND tag_name='" . $tagName . "';";
}
function getTagID($user_id, $tagName)
{
    $con = db_connection();
    $result = mysqli_query($con, getTagIDQuery($user_id, $tagName));
    return mysqli_fetch_row($result)[0];
}