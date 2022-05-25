<?php
session_start();
include '../funkce.php';
include '../adminPanel/adminPanelFunctions.php';

ifNotAdminRedirect();
if(is_admin($_SESSION["UID"]) == 2)
{
    $userPromoteUID = test_input($_GET["uid"]);
    if(is_admin($userPromoteUID))
    {
        header("Location: /adminPanel/users.php");
        die();
    }
    else
    {
        $con = db_connection();
        $query = "UPDATE user SET admin='1' WHERE uid = '" . $userPromoteUID . "';";
        mysqli_query($con, $query);
        header("Location: /adminPanel/users.php");
        die();
    }
}
else
{
    header("Location: /adminPanel/users.php");
}


