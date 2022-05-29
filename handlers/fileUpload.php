<?php
session_start();
include_once '../functions/globalFunctions.php';

$userFolder = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $_SESSION["UID"] . "/";
$userFiles = $userFolder . "/files/";
$userImages = $userFolder . "/images/";

if (isset($_POST["fileManagerUpload"]))
{
    if (isset($_POST["makeFolder"]) && $_POST["makeFolder"] == "Yes")
    {
        $folder = test_input($_POST["folderToMake"]);
        $finalPath = $userFiles . $folder;
        if (!file_exists($finalPath))
        {
            mkdir($finalPath);
            $fileName = $_FILES["files"]["name"];
            $finalPath .= "/" . $fileName;
            move_uploaded_file($_FILES["files"]["tmp_name"], $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $fileName = $_FILES["files"]["name"];
            $finalPath .= "/" . $fileName;
            move_uploaded_file($_FILES["files"]["tmp_name"], $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
    else
    {
        if (isset($_POST["directory"]))
        {
            $folder = $_POST["directory"];

            $fileName = $_FILES["files"]["name"];
            $finalPath = $userFiles . $folder . "/" . $fileName;
            move_uploaded_file($_FILES["files"]["tmp_name"], $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $fileName = $_FILES["files"]["name"];
            $finalPath = $userFiles .  "/" . $fileName;
            move_uploaded_file($_FILES["files"]["tmp_name"], $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
}
header("Location: " . $_SESSION["PAGE"]);
die();
