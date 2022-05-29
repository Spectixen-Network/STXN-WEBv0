<?php
session_start();
include_once 'functions/globalFunctions.php';
include_once 'functions/fileManagerFunctions.php';

isLoggedElseRedirect();
if (isset($_GET["uid"]) && is_admin($_SESSION["UID"]))
{
    $_SESSION["FILE_MANAGER_UID"] = $_GET["uid"];
}
if (isset($_SESSION["FILE_MANAGER_UID"]))
{
    $uid = $_SESSION["FILE_MANAGER_UID"];
}
else
{
    $uid = $_SESSION["UID"];
}
$basePath = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $uid  . "/files/";
$dir = "";
if (isset($_GET["dir"]))
{
    if (file_exists($basePath . test_input($_GET["dir"])))
    {
        $dir = test_input($_GET["dir"]);
    }
    else
    {
        header("Location: fileManager.php");
    }
}
if (isset($_POST["rename"]))
{
    $newName = test_input($_POST["rename"]);
    if ($dir == "")
    {
        if (is_dir($basePath . $_POST["fileToRename"]))
        {
            $ext = "";
        }
        else
        {
            $ext = "." . pathinfo($basePath . $dir . "/" . $_POST["fileToRename"])["extension"];
        }
        rename($basePath . $_POST["fileToRename"], $basePath . $newName . $ext);
        header("Location: fileManager.php");
    }
    else
    {
        if (is_dir($basePath . $_POST["fileToRename"]))
        {
            $ext = "";
        }
        else
        {
            $ext = "." . pathinfo($basePath . $dir . "/" . $_POST["fileToRename"])["extension"];
        }
        rename($basePath . $dir . "/" . $_POST["fileToRename"], $basePath . $dir . "/" . $newName . $ext);
        header("Location: fileManager.php?dir=" . $dir);
    }
}


html_start("Files", "css/style");
//echo '<script src="/scripts/customContextMenu.js"></script>';
nav();
banner("File Manager");

if (isset($_GET["delFolder"]))
{
    $folder = test_input($_GET["delFolder"]);
    if (file_exists($basePath . $folder))
    {
        $folderContentToDelete = scandir($basePath . $folder);
        foreach ($folderContentToDelete as $value)
        {
            if ($value == "." || $value == "..") continue;
            else
            {
                unlink($basePath . $folder . "/" . $value);
            }
        }
        rmdir($basePath . $folder);
    }
    else
    {
        echo "Folder '$folder' doesn't exists!";
    }
}


if (isset($_POST["createFolder"]) && $_POST["createFolder"] !== "")
{
    $folder = test_input($_POST["createFolder"]);
    $folderPath = $basePath . $folder;
    if (file_exists($folderPath))
    {
        echo "Folder '$folder' already exists!";
    }
    else
    {
        mkdir($basePath . $folder);
    }
}
if (isset($_GET["delFile"]))
{
    $file = test_input($_GET["delFile"]);
    unlink($file);
    echo '<script>window.location.href = "fileManager.php";</script>';
}

?>

<div class="container-fluid">
    <div class="row">
        <?php ibox($basePath); ?>
        <div class="col-lg-10">
            <div class="container-fluid" id="topBarInFileManager">
                <div class="row">
                    <form class="col-md-2 d-flex">
                        <input class="form-control me-2" type="text" placeholder="Search">
                        <button class="btn btn-primary" type="button">Search</button>
                    </form>
                </div>
            </div>
            <div id="files">
                <!-- <div class="file-box">
                        <div class="file">
                            <a href="#">
                                <span class="corner">

                                </span>
                                <div class="icon">
                                    <i class="img-responsive fa fa-film">

                                    </i>
                                </div>
                                <div class="file-name">
                                    ' . $fileName . '
                                    <br>
                                    <small>Added: Fab 18, 2014</small>
                                </div>
                            </a>
                        </div>
                    </div> -->
                <?php
                folderContent($dir, $uid);
                ?>
            </div>
        </div>
    </div>
</div>
</div>






<?php
uploadModal($basePath);
moveModal($basePath);
footer();
html_end();