<?php
session_start();
include '../funkce.php';
include '../adminPanel/adminPanelFunctions.php';

ifNotAdminRedirect();

$userToDeleteUID = test_input($_GET["uid"]);
$basePath = $_SERVER["DOCUMENT_ROOT"] . "/user/";

if(!is_admin($_SESSION["UID"]))
{
    header("Location: /adminPanel/users.php");
    die();
}
if(is_admin($userToDeleteUID) && is_admin($_SESSION["UID"]) != 2)
{
    header("Location: /adminPanel/users.php");
    die();
}
else
{
    if(uid_exist($userToDeleteUID))
    {
        $con = db_connection();
        $query = "DELETE FROM user WHERE uid = ". $userToDeleteUID;
        deleteUserFolder($basePath, $userToDeleteUID);
        mysqli_query($con, $query);
        header("Location: /adminPanel/users.php");
        die();
    }
    else
    {
        header("Location: /adminPanel/users.php");
        die();
    }
}

function deleteUserFolder($basePath, $folder)
{
    $basePath .= $folder."/";
    if (file_exists($basePath))
    {
        $folderContentToDelete = scandir($basePath);
        foreach ($folderContentToDelete as $value)
        {
            if($value == "." || $value == "..") continue;
            if(is_dir($basePath . $value))
            {
                deleteUserFolder($basePath, $value);
            }
            else
            {
                unlink($basePath . $value);
            }
        }
        rmdir($basePath);
    }
    else
    {
        die();
    }
}