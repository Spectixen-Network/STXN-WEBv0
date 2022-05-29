<?php
session_start();
include_once '../functions/globalFunctions.php';

$userFolder = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $_POST["userDirectory"] . "/";
$userFiles = $userFolder . "/files/";
$userImages = $userFolder . "/images/";

$fileToMove = $_POST["fileToMove"];
if ($_POST["inFolder"] != "")
{
    $inFolder = $_POST["inFolder"] . "/";
}

if (isset($_POST["fileManagerMove"]))
{
    if (isset($_POST["makeFolder"]) && $_POST["makeFolder"] == "Yes")
    {
        $folder = test_input($_POST["folderToMake"]);
        $finalPath = $userFiles . $folder;
        if (!file_exists($finalPath))
        {
            mkdir($finalPath);
            $fileName = $fileToMove;
            $finalPath .= "/" . $fileName;
            rename($userFiles . $inFolder . $fileToMove, $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $fileName = $fileToMove;
            $finalPath .= "/" . $fileName;
            rename($userFiles . $inFolder . $fileToMove, $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
    else
    {
        if (isset($_POST["directory"]))
        {
            $folder = $_POST["directory"];

            $fileName = $fileToMove;
            $finalPath = $userFiles . $folder . "/" . $fileName;
            rename($userFiles . $inFolder . $fileToMove, $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $fileName = $fileToMove;
            $finalPath = $userFiles .  "/" . $fileName;
            rename($userFiles . $inFolder . $fileToMove, $finalPath);
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
}
header("Location: " . $_SESSION["PAGE"]);
die();