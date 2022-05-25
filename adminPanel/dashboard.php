<?php
session_start();
include '../funkce.php';
include  'adminPanelFunctions.php';
ifNotAdminRedirect();


html_start("Admin", "css/style");
nav();

adminDashnoard();

html_end();

function adminDashnoard()
{
    echo
    '
        <div class="container-fluid ">
            <div class="container-fluid" id="adminPanelHeader">
                <h1>Admin Panel</h1>
            </div>
            <div class="row">';

    adminSidebar();

    echo '
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
    ';
}