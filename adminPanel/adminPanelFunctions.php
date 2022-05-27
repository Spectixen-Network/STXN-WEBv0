<?php

$GLOBALS["absoluteUserDirPath"] = $_SERVER["DOCUMENT_ROOT"] . "/user/" . $_SESSION["UID"]  . "/";
$GLOBALS["relativeUserDirPath"] = "../user/" . $_SESSION["UID"] . "/";
$GLOBALS["userImageFolder"] = "images/";
$GLOBALS["userFilesFolder"] = "files/";

function adminSidebar()
{
    echo
    '
        <!-- Sidebar  -->
        <div class="container col-2 " id="adminSidebarContainer">

            <nav id="adminSidebar">
                <div class="adminSidebarHeader">
                    <div class="row" style="margin-bottom: 0;">
                        <h3 id="administratorNicknameHeader" class="col-9">' . $_SESSION["USERNAME"] . '</h3>
                        <div class="btn dropdown-toggle col-3">
                            <img src="' . $GLOBALS["relativeUserDirPath"] . navbar_profile_image() . '" width="30" height="30" class="rounded-circle">
                        </div>
                    </div>
                    <p id="administratorNicknameFooter" style="color: gray;">Administrator</p>
                </div>

                <ul class="folder-list" style="padding-left: 0; padding-right: 0.5vh; padding-bottom: 100%">
                    <li><a href="/adminPanel/dashboard.php"><i class="fa fa-folder"></i> Dashboard</a></li>
                    <li><a href="/adminPanel/users.php"><i class="fa fa-folder"></i> Users</a></li>
                    <!--<li><a href=""><i class="fa fa-folder"></i> Mail</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Calendar</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Icons</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Forms</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Charts</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Maps</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Layouts</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Tables</a></li>-->
                </ul>

            </nav>
        </div>
        <!-- Sidebar end -->
    ';
}
function ifNotAdminRedirect()
{
    if (!is_admin($_SESSION["UID"]))
    {
        header("Location: /index.php");
    }
}