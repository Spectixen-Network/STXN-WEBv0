<?php
session_start();
include_once '../functions/globalFunctions.php';
include_once '../functions/adminPanelFunctions.php';

ifNotAdminRedirect();

$userToUnBanUID = test_input($_GET["uid"]);

if (!is_admin($_SESSION["UID"]))
{
    header("Location: /index.php");
    die();
}
if (is_banned($userToUnBanUID))
{
    $con = db_connection();
    $query = "DELETE FROM banneduser WHERE uid = " . $userToUnBanUID;
    mysqli_query($con, $query);
    header("Location: /adminPanel/users.php");
    die();
}
else
{
    header("Location: /adminPanel/users.php");
    die();
}