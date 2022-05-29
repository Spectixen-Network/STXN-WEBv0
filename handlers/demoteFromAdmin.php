<?php
session_start();
include_once '../functions/globalFunctions.php';
include_once '../functions/adminPanelFunctions.php';

ifNotAdminRedirect();
if (is_admin($_SESSION["UID"]) == 2)
{
    $userDemoteUID = test_input($_GET["uid"]);
    if (!is_admin($userDemoteUID))
    {
        header("Location: /adminPanel/users.php");
        die();
    }
    else
    {
        $con = db_connection();
        $query = "UPDATE user SET admin='0' WHERE uid = '" . $userDemoteUID . "';";
        mysqli_query($con, $query);
        header("Location: /adminPanel/users.php");
        die();
    }
}
else
{
    header("Location: /adminPanel/users.php");
}