<?php
session_start();
include '../funkce.php';
include  'adminPanelFunctions.php';
ifNotAdminRedirect();


html_start("Admin", "css/style");
nav();
echo
'
        <div class="container-fluid ">
            <div class="container-fluid" id="adminPanelHeader">
                <h1>Users Panel</h1>
            </div>
            <div class="row">';
adminSidebar();
?>

<div class="col-10">
    <!-- UserList start -->
    <div class="row">
        <div class="col-4 ms-1 userLists" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); height: 75vh; overflow-y: auto">
            <span class="d-flex justify-content-center mt-1" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px);">
                <h2>All Users</h2>
            </span>

            <?php listAllUsers(); ?>

        </div>
        <!-- userList end -->

        <!-- bannedUsersList start -->
        <div class="col-5 ms-1" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); height: 30vh; overflow-y: auto">
            <div class="column">
                <div>
                    <span class="d-flex justify-content-center mt-1" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px);">
                        <h2>Banned Users</h2>
                    </span>
                    <?php listAllBannedUsers(); ?>
                </div>
            </div>
        </div>
        <!-- bannedUsersList end -->

        <div class="col-3">

        </div>
    </div>
</div>
<?php
echo '      </div>
        </div>';

html_end();


//User list start
function userListsListUser($userId, $userUsername, $userAdmin)
{


    if (is_admin($_SESSION["UID"]) == 2)
    {
        echo
        '
                <!-- oneUser start -->
                <div class="mt-1 userList" >
                    <div class="row" style="width: 100%; margin: 0;">
                        <span class="col-8">
                            <p class="m-0 p-1 col" style="overflow-x: hidden">[ ' . $userId . ' ] ' . $userUsername . '</p>
                        </span>
                        <span class="col-4 d-flex align-content-center flex-wrap">
                            <div class="row">
                                <span class="col-3">';
        if ($userAdmin)
        {
            if ($userAdmin == 1)
            {
                echo '      <a href="/handlers/demoteFromAdmin.php?uid=' . $userId . '" title="Admin --> Casual User"><i class="bi bi-file-medical-fill"></i></a>';
            }
            if ($userAdmin == 2)
            {
                echo '      <a href="" style="cursor: default" title="Owner"><i class="fas fa-crown"></i></a>';
            }
        }
        else
        {
            echo '      <a href="/handlers/promoteToAdmin.php?uid=' . $userId . '" title="Casual User --> Admin"><i class="fa-solid fa-circle-user"></i></a>';
        }
        echo
        '                  </span>
                                <span class="col-3">
                                    <a href="#" tittle="Search User"><i class="bi bi-search"></i></a>
                                </span>
                                <span class="col-3">';
        if (!is_banned($userId))
        {
            echo ' <a href="/handlers/banUser.php?uid=' . $userId . '" tittle="Ban User"><i class="bi bi-hammer col"></i></a>';
        }
        echo '                  </span>
                                <span class="col-3">
                                    <a href="/handlers/deleteUser.php?uid=' . $userId . '" tittle="Delete User"><i class="bi bi-trash"></i></a>
                                </span>
                            </div>
                        </span>
                    </div>
                </div>
                <!-- oneUser end -->
        ';
    }
    else
    {
        echo
        '
                <!-- oneUser start -->
                <div class="mt-1 userList" style="">
                    <div class="row" style="width: 100%; margin: 0;">
                        <span class="col-8">
                            <p class="m-0 p-1 col" style="overflow-x: hidden">[ ' . $userId . ' ] ' . $userUsername . '</p>
                        </span>
                        <span class="col-4 d-flex align-content-center flex-wrap">
                            <div class="row">
                                <span class="col-3">';
        if ($userAdmin)
        {
            if ($userAdmin == 1)
            {
                echo '      <a href="" style="cursor: default" title="Admin"><i class="bi bi-file-medical-fill"></i></a>';
            }
            if ($userAdmin == 2)
            {
                echo '      <a href="" style="cursor: default" title="Owner"><i class="fas fa-crown"></i></a>';
            }
        }
        else
        {
            echo '          <a href="" style="cursor: default" title="Casual User"><i class="fa-solid fa-circle-user"></i></a>';
        }
        echo '                  </span>
                                <span class="col-3">
                                    <a href="#" tittle="Search User"><i class="bi bi-search"></i></a>
                                </span>
                                <span class="col-3">';
        if (!is_banned($userId))
        {
            echo '<a href="/handlers/banUser.php?uid=' . $userId . '" tittle="Ban User"><i class="bi bi-hammer col"></i></a>';
        }
        echo '                  </span>
                                <span class="col-3">
                                    <a href="/handlers/deleteUser.php?uid=' . $userId . '" tittle="Delete User"><i class="bi bi-trash"></i></a>
                                </span>
                            </div>
                        </span>
                    </div>
                </div>
                <!-- oneUser end -->
        ';
    }
}
function listAllUsers()
{
    $con = db_connection();

    $query = "SELECT uid, username, admin FROM user;";
    $result = mysqli_query($con, $query);
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        userListsListUser($row["uid"], $row["username"], $row["admin"]);
    }
}
//User list end

function bannedListListUser($userId, $userUsername, $from_date, $to_date)
{
    echo '
    <!-- oneUser start -->
    <div class="mt-1 userList" style="">
        <div class="row" style="width: 100%; margin: 0;">
            <span class="col-11 row">
                <p class="m-0 p-1 col-4" style="overflow-x: hidden">[ ' . $userId . ' ] ' . $userUsername . '</p>
                <p class="m-0 p-1 col-4" style="overflow-x: hidden">From: ' . date_formatted($from_date) . '</p>
                <p class="m-0 p-1 col-4" style="overflow-x: hidden">To: ' . date_formatted($to_date) . '</p>
            </span>
            <span class="col-1 d-flex align-content-center flex-wrap">
                <div class="row">
                    <span class="col-3">
                    </span>
                    <span class="col-3">
                    </span>
                    <span class="col-3">
                    </span>
                    <span class="col-3">
                        <a href="/handlers/unBanUser.php?uid='.$userId.'"><i class="fa-solid fa-ban"></i></a>
                    </span>
                </div>
            </span>
        </div>
    </div>
    <!-- oneUser end -->';
}
function listAllBannedUsers()
{
    $con = db_connection();

    $query = "SELECT bu.uid, u.username, bu.from_date, bu.to_date FROM banneduser bu INNER JOIN user u USING(uid);";
    $result = mysqli_query($con, $query);
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        bannedListListUser($row["uid"], $row["username"], $row["from_date"], $row["to_date"]);
    }
}