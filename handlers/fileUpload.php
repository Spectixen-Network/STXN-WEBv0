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
            $countfiles = count($_FILES['files']['name']);
            for ($i = 0; $i < $countfiles; $i++)
            {
                $fileName = $_FILES["files"]["name"][$i];
                $tmpFileName = $_FILES["files"]["tmp_name"][$i];
                $finalPath .= "/" . $fileName;
                move_uploaded_file($tmpFileName, $finalPath);
            }
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $countfiles = count($_FILES['files']['name']);
            for ($i = 0; $i < $countfiles; $i++)
            {
                $fileName = $_FILES["files"]["name"][$i];
                $tmpFileName = $_FILES["files"]["tmp_name"][$i];
                $finalPath .= "/" . $fileName;
                move_uploaded_file($tmpFileName, $finalPath);
            }
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
    else
    {
        if (isset($_POST["directory"]))
        {
            $folder = $_POST["directory"];
            $countfiles = count($_FILES['files']['name']);
            for ($i = 0; $i < $countfiles; $i++)
            {
                $fileName = $_FILES["files"]["name"][$i];
                $tmpFileName = $_FILES["files"]["tmp_name"][$i];
                $finalPath = $userFiles . $folder . "/" . $fileName;
                move_uploaded_file($tmpFileName, $finalPath);
            }
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
        else
        {
            $countfiles = count($_FILES['files']['name']);
            for ($i = 0; $i < $countfiles; $i++)
            {
                $fileName = $_FILES["files"]["name"][$i];
                $tmpFileName = $_FILES["files"]["tmp_name"][$i];
                $finalPath = $userFiles .  "/" . $fileName;
                move_uploaded_file($tmpFileName, $finalPath);
            }
            header("Location: " . $_SESSION["PAGE"]);
            die();
        }
    }
}
header("Location: " . $_SESSION["PAGE"]);
die();