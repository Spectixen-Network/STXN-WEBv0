<?php
session_start();
include_once '../functions/globalFunctions.php';
include_once '../functions/adminPanelFunctions.php';

ifNotAdminRedirect();

$userToBanUID = test_input($_GET["uid"]);

if (!is_admin($_SESSION["UID"]))
{
    header("Location: /index.php");
    die();
}
if (is_admin($userToBanUID) && is_admin($_SESSION["UID"]) != 2)
{
    header("Location: /adminPanel/users.php");
    die();
}
else
{
    $con = db_connection();
    if (!is_banned($userToBanUID))
    {
        $query = "INSERT INTO banneduser(uid, from_date, to_date) VALUES ('" . $userToBanUID . "', '" . curr_date_to_DB() . "', '2022-05-26')";
        mysqli_query($con, $query);
    }
    header("Location: /adminPanel/users.php");
    die();
}