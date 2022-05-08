<?php
session_start();
include '../funkce.php';

html_start("Admin", "../css/style");
nav();

?>

<div class="container-fluid ">
    <div class="container-fluid" id="adminPanelHeader">
        <h1>Admin Panel</h1>
    </div>
    <div class="row">
        <!-- Sidebar  -->
        <div class="container col-2" id="adminSidebarContainer">

            <nav id="adminSidebar">
                <div class="adminSidebarHeader">
                    <div class="row" style="margin-bottom: 0;">
                        <h3 id="administratorNicknameHeader" class="col-9">Nickname</h3>
                        <div class="btn dropdown-toggle col-3">
                            <img src="/' . navbar_profile_image() . '" width="30" height="30" class="rounded-circle">
                        </div>
                    </div>
                    <p id="administratorNicknameFooter" style="color: gray;">Administrator</p>
                </div>

                <ul class="folder-list" style="padding-left: 0; padding-right: 0.5vh; padding-bottom: 100%">
                    <li><a href=""><i class="fa fa-folder"></i> Dashboard</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Users</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Mail</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Calendar</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Icons</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Forms</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Charts</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Maps</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Layouts</a></li>
                    <li><a href=""><i class="fa fa-folder"></i> Tables</a></li>
                </ul>

            </nav>
        </div>



        <div class="container col-10">
            <div class="row">
                <div class="col-3" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelTotalUsers">Total users</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
                <div class="col-3" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelNewUsers">New users</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
                <div class="col-3" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelBannedUsers">Banned users</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
                <div class="col-3" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelUniqueVisitors">Unique visitors</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-8" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div>
                        <div id="adminPanelLargeGraph">Website stats graph large</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                    </div>
                </div>
                <div class="col-4" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div>
                        <div id="adminPanelSmallGraph">Website stats graph rounded</div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelInbox">Inbox</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
                <div class="col-4" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelAdminChat">Admin Chat</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
                <div class="col-4" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); border: 3px solid rgba(0, 0, 0, .2);">
                    <div id="adminPanelToDoList">TO DO LIST</div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga veniam totam, porro animi iste, accusamus odio ipsum velit beatae neque debitis recusandae! Omnis nam nulla consequuntur, distinctio corporis asperiores minima.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

html_end();
