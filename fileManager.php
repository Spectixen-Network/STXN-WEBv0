<?php
session_start();

if (!isset($_SESSION["UID"]))
{
    header("Location: /index.php");
    die();
}

include 'funkce.php';

$basePath = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $_SESSION["UID"] . "/files/";
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


html_start("Files", "css/style");
nav();
banner("File Manager");

if (isset($_GET["delFolder"]))
{
    $folder = test_input($_GET["delFolder"]);
    if (file_exists($basePath . $folder))
    {
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

?>



<div class="container-fluid">
    <div class="row">
        <?php ibox($basePath); ?>
        <div class="col-lg-10">
            <div class="container-fluid" id="topBarInFileManager">
                <div class="row">
                    <div class="col-1">
                        <div class="row">
                            <span class="col-5">
                                <a>Sort by:</a>
                            </span>
                            <span class="col-3">
                                <a>abc</a>
                            </span>
                            <span class="col-3">
                                <a>xyz</a>
                            </span>
                        </div>
                    </div>
                    <form class="col-md-2 d-flex">
                        <input class="form-control me-2" type="text" placeholder="Search">
                        <button class="btn btn-primary" type="button">Search</button>
                    </form>
                </div>
            </div>
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
            folderContent($dir);
            ?>
        </div>
    </div>
</div>
</div>






<?php
uploadModal($basePath);
html_end();

function uploadModal($path)
{
    $directories = scandir($path);
    echo
    '
        <!-- Upload Modal -->
        <div class="modal fade" id="uploadModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Upload modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Upload files</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Upload Modal body -->
                    <div class="container">
                        <form action="/handlers/fileUpload.php" class="was-validated" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="fileManagerUpload" value="1">
                            <div class="form-floating mt-3 mb-3">';
    $numOfDirs = 0;
    for ($i = 0; $i < count($directories); $i++)
    {
        if (is_dir($path . $directories[$i]) && $directories[$i] != '.' && $directories[$i] != '..')
        {
            $numOfDirs++;
        }
    }
    if (count($directories) > 2 && $numOfDirs > 0)
    {
        echo '                  <select name="directory" class="form-select" id="folderSelector">
                                    <option disabled selected value> -- select a directory to upload to -- </option>
                                    <option value="">/</option>';
        for ($i = 0; $i < count($directories); $i++)
        {
            if (is_dir($path . $directories[$i]) && $directories[$i] != '.' && $directories[$i] != '..')
            {
                echo '              <option value="' . $directories[$i] . '">' . $directories[$i] . '</option>';
            }
        }
        echo '                  </select><label for="directory" id="folderSelectorLabel">Directory</label><br>';
    }

    echo '                      <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" onclick="toggleMakeFolder();" id="mySwitch" name="makeFolder" value="Yes">
                                    <label class="form-check-label" for="mySwitch">Make folder</label>
                                </div>
                                <div class="form-floating mt-3 mb-3 showNone" id="folderNameInput">
                                    <input type="text" class="form-control" placeholder="Some text" name="folderToMake" id="folderName">
                                    <label for="folderToMake">Folder Name</label>
                                </div>
                                <script>
                                    function toggleMakeFolder()
                                    {
                                            document.getElementById("folderName").required = !document.getElementById("folderName").required;
                                            document.getElementById("folderNameInput").classList.toggle("showNone");
                                            document.getElementById("folderSelector").classList.toggle("showNone");
                                            document.getElementById("folderSelectorLabel").classList.toggle("showNone");
                                    }
                                </script><br>
                                <input type="file" class="form-control-file" id="file" placeholder="add files." name="files" required>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <button id="uploadSubmit" type="submit" class="btn btn-success">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upload Modal End --->
    ';
}
function ibox($path)
{
    $dir = "";
    if (isset($_GET["dir"]))
    {
        if (file_exists(test_input($_GET["dir"])))
        {
            $dir = "dir=" . test_input($_GET["dir"]);
        }
    }

    $directories = scandir($path);
    echo
    '
        <div class="col-md-2">
            <div class="ibox float-e-margins">
                <div class="ibox-content" id="fileManagerSideRowBox">
                    <div class="file-manager">
                        <h5>Show:</h5>
                        <a href="?' . $dir . '" class="file-control">None</a>
                        <a href="?type=video&' . $dir . '" class="file-control">Video</a>
                        <a href="?type=audio&' . $dir . '" class="file-control">Audio</a>
                        <a href="?type=images&' . $dir . '" class="file-control">Images</a>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Files</button>

                        <div class="hr-line-dashed"></div>
                        <h5>Folders</h5>
                        <ul class="folder-list" style="padding: 0">
                            <li><a href="/fileManager.php"><i class="fa fa-folder"></i>/</a></li>';
    for ($i = 0; $i < count($directories); $i++)
    {
        if (is_dir($path . $directories[$i]) && $directories[$i] != '.' && $directories[$i] != '..')
        {
            echo '          <li>
                            <span class="row" style="padding: 0px 12px;">
                                <a class="col-9" href="/fileManager.php?dir=' . $directories[$i] . '">
                                    <i class="fa fa-folder"></i>
                                    ' . $directories[$i] . '
                                </a>
                                <a class="col-2" href="?delFolder=' . $directories[$i] . '">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </span>
                            </li>';
        }
    }
    echo '             <form method="POST" id="createFolderForm" class="showNone">
                             <li><a><i class="fa fa-folder col-1"></i><input type="text" name="createFolder" onfocusout="formSubmit()" class="col-9 createFolder" id="createFolder" placeholder="Folder Name" style="background-color: rgba(83, 83, 83, 0.2); color: #ffff; border: none" required></a></li>
                        </form>
                            <li><a onclick="folderCreate()" style="cursor: pointer; color: #ffff;"><i class="bi bi-plus-square-fill"></i> Crate new folder</a></li>
                        </ul>
                                    <!-- <h5 class="tag-title">Tags</h5>
                                    <ul class="tag-list" style="padding: 0">
                                        <li><a href="">Family</a></li>
                                        <li><a href="">Work</a></li>
                                        <li><a href="">Home</a></li>
                                        <li><a href="">Children</a></li>
                                        <li><a href="">Holidays</a></li>
                                        <li><a href="">Music</a></li>
                                        <li><a href="">Photography</a></li>
                                        <li><a href="">Film</a></li>
                                    </ul> -->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function formSubmit()
            {
                document.getElementById("createFolderForm").submit();
            }
            function folderCreate()
            {
                document.getElementById("createFolderForm").classList.remove("showNone");
                document.getElementById("createFolder").focus();
            }
        </script>
    ';
}
function folderContent($folder = "")
{
    $path = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $_SESSION["UID"] . "/files/" . $folder;

    $folderContent = scandir($path);
    $folderContent = sortDirFirst($path, $folderContent);
    for ($i = 0; $i < count($folderContent); $i++)
    {
        if (is_dir($path . $folderContent[$i]))
        {
            dirFileEcho($folderContent[$i]);
        }
        else
        {
            determinFile($folderContent[$i]);
        }
    }
}
function determinFile($fileName)
{
    $fileType = pathinfo($fileName)["extension"];

    $imageFormats = ["jpg", "jpeg", "gif", "png", "apng", "svg", "bmp"];
    $audioFormats = ["mp3", "wav", "ogg"];
    $videoFormats = ["mp4", "webm", "ogg"];
    $type = true;
    if (isset($_GET["type"]))
    {
        $type = test_input($_GET["type"]);
    }

    if (in_array($fileType, $imageFormats))
    {
        if ($type === "images" || $type === true)
        {
            imageFileEcho($fileName);
        }
        return;
    }
    if (in_array($fileType, $audioFormats))
    {
        if ($type === "audio" || $type === true)
        {
            audioFileEcho($fileName);
        }
        return;
    }
    if (in_array($fileType, $videoFormats))
    {
        if ($type === "video" || $type === true)
        {
            videoFileEcho($videoFormats);
        }
        return;
    }
    if ($type === true)
    {
        elseFileEcho($fileName);
    }
}
function sortDirFirst($path, $array)
{
    $dirArray = [];
    $rest = [];

    for ($i = 2; $i < count($array); $i++)
    {
        if (is_dir($path . $array[$i]))
        {
            array_push($dirArray, $array[$i]);
        }
        else
        {
            array_push($rest, $array[$i]);
        }
    }
    sort($dirArray);
    sort($rest);

    return array_merge($dirArray, $rest);
}

function audioFileEcho($fileName)
{
    echo
    '
            <div class="file-box">
                <div class="file">
                    <a href="#">
                        <span class="corner"></span>
            
                        <div class="icon">
                            <i class="fa fa-music"></i>
                        </div>
                        <div class="file-name">
                            ' . $fileName . '
                            <br>
                            <small>Added: Jan 22, 2014</small>
                        </div>
                    </a>
                </div>
            </div>
        ';
}
function videoFileEcho($fileName)
{
    echo
    '
            <div class="file-box">
                <div class="file">
                    <a href="#">
                        <span class="corner"></span>
            
                        <div class="icon">
                            <i class="img-responsive fa fa-film"></i>
                        </div>
                        <div class="file-name">
                            ' . $fileName . '
                            <br>
                            <small>Added: Fab 18, 2014</small>
                        </div>
                    </a>
                </div>
            </div>
        ';
}
function imageFileEcho($fileName)
{
    if (isset($_GET["dir"]))
    {
        $dir = test_input($_GET["dir"]) . "/";
    }
    else
    {
        $dir = "";
    }
    echo
    '
            <div class="file-box">
                <div class="file">
                    <a href="#">
                        <span class="corner"></span>
            
                        <div class="image">
                            <img alt="' . $fileName . '" class="img-fluid" src="/user/' . $_SESSION["UID"] . '/files/' . $dir . $fileName . '">
                        </div>
                        <div class="file-name">
                            ' . $fileName . '
                            <br>
                            <small>Added: Jan 6, 2014</small>
                        </div>
                    </a>
                </div>
            </div>
        ';
}
function elseFileEcho($fileName)
{
    echo
    '
            <div class="file-box">
                <div class="file">
                    <a href="#">
                        <span class="corner"></span>
            
                        <div class="icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="file-name">
                            ' . $fileName . '
                            <br>
                            <small>Added: Jan 22, 2014</small>
                        </div>
                    </a>
                </div>
            </div>
        ';
}
function dirFileEcho($fileName)
{
    echo
    '
            <div class="file-box">
                <div class="file">
                    <a href="/fileManager.php?dir=' . $fileName . '">
                        <span class="corner"></span>
            
                        <div class="icon">
                            <i class="fa fa-folder"></i>
                        </div>
                        <div class="file-name">
                            ' . $fileName . '
                            <br>
                            <small>Added: Jan 22, 2014</small>
                        </div>
                    </a>
                </div>
            </div>
        ';
}