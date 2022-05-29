<?php
include_once 'globalFunctions.php';

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
                                <input type="file" class="form-control-file" id="file" placeholder="add files." name="files[]" required multiple>
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
function moveModal($path)
{
    $directories = scandir($path);
    echo
    '
        <!-- Move Modal -->
        <div class="modal fade" id="moveModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Move modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Move file</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Move Modal body -->
                    <div class="container">
                        <form action="/handlers/moveFile.php" class="was-validated" method="POST">
                            <input type="hidden" name="fileManagerMove" value="1">
                            <input type="hidden" name="fileToMove" id="fileToMove">
                            <input type="hidden" name="inFolder" id="inFolder">
                            <input type="hidden" name="userDirectory" id="userDirectory">
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
        echo '                  <select name="directory" class="form-select" id="folderSelector_">
                                    <option disabled selected value> -- select a directory to upload to -- </option>
                                    <option value="">/</option>';
        for ($i = 0; $i < count($directories); $i++)
        {
            if (is_dir($path . $directories[$i]) && $directories[$i] != '.' && $directories[$i] != '..')
            {
                echo '              <option value="' . $directories[$i] . '">' . $directories[$i] . '</option>';
            }
        }
        echo '                  </select><label for="directory" id="folderSelectorLabel_">Directory</label><br>';
    }

    echo '                      <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" onclick="toggleMakeFolder();" id="mySwitch" name="makeFolder" value="Yes">
                                    <label class="form-check-label" for="mySwitch">Make folder</label>
                                </div>
                                <div class="form-floating mt-3 mb-3 showNone" id="folderNameInput_">
                                    <input type="text" class="form-control" placeholder="Some text" name="folderToMake" id="folderName_">
                                    <label for="folderToMake">Folder Name</label>
                                </div>
                                <script>
                                    function toggleMakeFolder()
                                    {
                                            document.getElementById("folderName_").required = !document.getElementById("folderName_").required;
                                            document.getElementById("folderNameInput_").classList.toggle("showNone");
                                            document.getElementById("folderSelector_").classList.toggle("showNone");
                                            document.getElementById("folderSelectorLabel_").classList.toggle("showNone");
                                    }
                                </script>
                            </div>
                            <button id="uploadSubmit" type="submit" class="btn btn-success">Move</button>
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

    if (isset($_GET["dir"]))
    {
        if (test_input($_GET["dir"]))
        {
            $dir = "dir=" . test_input($_GET["dir"]);
        }
        else
        {
            $dir = "";
        }
    }
    else
    {
        $dir = "";
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
function folderContent($folder = "", $uid)
{
    $path = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $uid . "/files/" . $folder;


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
            determinFile($folderContent[$i], $uid);
        }
    }
}
function determinFile($fileName, $uid)
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
            imageFileEcho($fileName, $uid);
        }
        return;
    }
    if (in_array($fileType, $audioFormats))
    {
        if ($type === "audio" || $type === true)
        {
            audioFileEcho($fileName, $uid);
        }
        return;
    }
    if (in_array($fileType, $videoFormats))
    {
        if ($type === "video" || $type === true)
        {
            videoFileEcho($fileName, $uid);
        }
        return;
    }
    if ($type === true)
    {
        elseFileEcho($fileName, $uid);
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

    return array_merge($dirArray, $rest);
}
function audioFileEcho($fileName, $uid)
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
            <div class="file-box" >
                <div class="file">
                    <span class="corner" style="z-index: 10" onclick="contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '();"></span>
                    <a href="#">
                        <div class="icon">
                            <i class="fa fa-music"></i>
                        </div>
                        <div class="file-name" style="overflow: hidden">
                            <p style="height: 24px; overflow: hidden;">' . $fileName . '</p>
                        </div>
                    </a>
                </div>
                <div id="contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '" class="contextMenu container-fluid showNone">
                    <ul style="list-style: none">
                        <li><a href="/user/' . $uid . '/files/' . $dir . $fileName . '" download><i class="bi bi-download"></i> Download</a></li>
                        <li><button onclick="renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-pencil-fill"></i> Rename</button></li>
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#moveModal" onclick="move_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-arrows-move"></i> Move</a></li>
                        <li><a href="?delFile=user/' . $uid . '/files/' . $dir . $fileName . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>    
                </div>
               <form method="POST" id="rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '">
                    <input type="hidden" id="rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '" name="rename">
                    <input type="hidden" name="fileToRename" value="' . $fileName . '">
                </form>
                <script>
                    function contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        let doc = document.getElementById("contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '");
                        doc.classList.toggle("showNone");
                    }
                    function renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '() {
                        let newName = prompt("Please enter new name:", "' . $fileName . '");
                        console.log(newName);
                        if (newName == null || newName == "") {
                        }
                        else
                        {
                            document.getElementById("rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '").setAttribute("value", newName);
                            document.getElementById("rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '").submit();
                        }
                    }
                    function move_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        document.getElementById("fileToMove").value = "' . $fileName . '";
                        document.getElementById("inFolder").value = "' . $dir . '";
                        document.getElementById("userDirectory").value = "' . $uid . '";
                    }
                </script>
            </div>
        ';
}
function videoFileEcho($fileName, $uid)
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
                    <span class="corner" style="z-index: 10" onclick="contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '();"></span>
                    <a href="#">
                        <div class="icon">
                            <i class="img-responsive fa fa-film"></i>
                        </div>
                        <div class="file-name" style="overflow: hidden">
                            <p style="height: 24px; overflow: hidden">' . $fileName . '</p>
                        </div>
                    </a>
                </div>
                <div id="contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '" class="contextMenu container-fluid showNone"> 
                    <ul style="list-style: none">
                        <li><a href="/user/' . $uid . '/files/' . $dir . $fileName . '" download><i class="bi bi-download"></i> Download</a></li>
                        <li><button onclick="renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-pencil-fill"></i> Rename</button></li>
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#moveModal" onclick="move_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-arrows-move"></i> Move</a></li>
                        <li><a href="?delFile=user/' . $uid . '/files/' . $dir . $fileName . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
                <form method="POST" id="rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '">
                    <input type="hidden" id="rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '" name="rename">
                    <input type="hidden" name="fileToRename" value="' . $fileName . '">
                </form>
                <script>
                    function contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        let doc = document.getElementById("contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '");
                        doc.classList.toggle("showNone");
                    }
                    function renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '() {
                        let newName = prompt("Please enter new name:", "' . $fileName . '");
                        console.log(newName);
                        if (newName == null || newName == "") {
                        }
                        else
                        {
                            document.getElementById("rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '").setAttribute("value", newName);
                            document.getElementById("rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '").submit();
                        }
                    }
                    function move_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        document.getElementById("fileToMove").value = "' . $fileName . '";
                        document.getElementById("inFolder").value = "' . $dir . '";
                        document.getElementById("userDirectory").value = "' . $uid . '";
                    }
                </script>
            </div>
        ';
}
function imageFileEcho($fileName, $uid)
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
                    <span class="corner" style="z-index: 10" onclick="contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '();"></span>
                    <a href="#">
                        <div class="image">
                            <img alt="' . $fileName . '" class="img-fluid" src="/user/' . $uid . '/files/' . $dir . $fileName . '">
                        </div>
                        <div class="file-name" style="overflow: hidden">
                            <p style="height: 24px; overflow: hidden">' . $fileName . '</p>
                        </div>
                    </a>
                </div>
                <div id="contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '" class="contextMenu container-fluid showNone">     
                    <ul style="list-style: none">
                        <li><a href="/user/' . $uid . '/files/' . $dir . $fileName . '" download><i class="bi bi-download"></i> Download</a></li>
                        <li><button onclick="renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-pencil-fill"></i> Rename</button></li>
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#moveModal" onclick="move_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-arrows-move"></i> Move</a></li>
                        <li><a href="?delFile=user/' . $uid . '/files/' . $dir . $fileName . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
                <form method="POST" id="rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '">
                    <input type="hidden" id="rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '" name="rename">
                    <input type="hidden" name="fileToRename" value="' . $fileName . '">
                </form>
                <script>
                    function contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        let doc = document.getElementById("contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '");
                        doc.classList.toggle("showNone");
                    }
                    function renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '() {
                        let newName = prompt("Please enter new name:", "' . $fileName . '");
                        console.log(newName);
                        if (newName == null || newName == "") {
                        }
                        else
                        {
                            document.getElementById("rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '").setAttribute("value", newName);
                            document.getElementById("rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '").submit();
                        }
                    }
                    function move_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        document.getElementById("fileToMove").value = "' . $fileName . '";
                        document.getElementById("inFolder").value = "' . $dir . '";
                        document.getElementById("userDirectory").value = "' . $uid . '";
                    }
                </script>
            </div>
        ';
}
function elseFileEcho($fileName, $uid)
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
                    <span class="corner" style="z-index: 10" onclick="contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '();"></span>
                    <a href="#">
                        <div class="icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="file-name" style="overflow: hidden">
                            <p style="height: 24px; overflow: hidden">' . $fileName . '</p>
                        </div>
                    </a>
                </div>
                <div id="contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '" class="contextMenu container-fluid showNone">
                    <ul style="list-style: none">
                        <li><a href="/user/' . $uid . '/files/' . $dir . $fileName . '" download><i class="bi bi-download"></i> Download</a></li>
                        <li><button onclick="renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-pencil-fill"></i> Rename</button></li>
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#moveModal" onclick="move_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-arrows-move"></i> Move</a></li>
                        <li><a href="?delFile=user/' . $uid . '/files/' . $dir . $fileName . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
                <form method="POST" id="rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '">
                    <input type="hidden" id="rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '" name="rename">
                    <input type="hidden" name="fileToRename" value="' . $fileName . '">
                </form>
                <script>
                    function contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        let doc = document.getElementById("contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '");
                        doc.classList.toggle("showNone");
                    }
                    function renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '() {
                        let newName = prompt("Please enter new name:", "' . $fileName . '");
                        console.log(newName);
                        if (newName == null || newName == "") {
                        }
                        else
                        {
                            document.getElementById("rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '").setAttribute("value", newName);
                            document.getElementById("rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '").submit();
                        }
                    }
                    function move_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        document.getElementById("fileToMove").value = "' . $fileName . '";
                        document.getElementById("inFolder").value = "' . $dir . '";
                        document.getElementById("userDirectory").value = "' . $uid . '";
                    }
                </script>
            </div>
        ';
}
function dirFileEcho($fileName)
{
    echo
    '
            <div class="file-box">
                <div class="file">
                    <span class="corner" style="z-index: 10" onclick="contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '();"></span>
                    <a href="/fileManager.php?dir=' . $fileName . '">
                        <div class="icon">
                            <i class="fa fa-folder"></i>
                        </div>
                        <div class="file-name" style="overflow: hidden">
                            <p style="height: 24px; overflow: hidden">' . $fileName . '</p>
                        </div>
                    </a>
                </div>
                <div id="contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '" class="contextMenu container-fluid showNone">
                    <ul style="list-style: none; margin: 0;">
                        <li><button onclick="renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '()"><i class="bi bi-pencil-fill"></i> Rename</button></li>
                        <li><a href="?delFolder=' . $fileName . '"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
                <form method="POST" id="rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '">
                    <input type="hidden" id="rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '" name="rename">
                    <input type="hidden" name="fileToRename" value="' . $fileName . '">
                </form>
                <script>
                    function contextMenu_' . str_replace([".", " ", "-"], "_", $fileName) . '()
                    {
                        let doc = document.getElementById("contextMenu-' . str_replace([".", " ", "-"], "_", $fileName) . '");
                        doc.classList.toggle("showNone");
                    }
                    function renameInput_' . str_replace([".", " ", "-"], "_", $fileName) . '() {
                        let newName = prompt("Please enter new name:", "' . $fileName . '");
                        console.log(newName);
                        if (newName == null || newName == "") {
                        }
                        else
                        {
                            document.getElementById("rename_input_' . str_replace([".", " ", "-"], "_", $fileName) . '").setAttribute("value", newName);
                            document.getElementById("rename_form_' . str_replace([".", " ", "-"], "_", $fileName) . '").submit();
                        }
                    }
                </script>
            </div>
            
        ';
}