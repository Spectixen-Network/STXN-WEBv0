<?php
session_start();
include '../funkce.php';

include  'adminPanelFunctions.php';

html_start("Admin", "../css/style");
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
        <div class="col-4 ms-1" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px); height: 30vh; overflow-y: auto">
            <div class="column">
                <div>
                    <span class="d-flex justify-content-center mt-1" style="background-color: rgba(83, 83, 83, 0.2); backdrop-filter: blur(10px);">
                        <h2>Banned Users</h2>
                    </span>

                </div>
                <div>
                    test2
                </div>
            </div>
        </div>
        <!-- bannedUsersList end -->

        <div class="col-4">

        </div>
    </div>
</div>
<?php
echo '      </div>
        </div>';

html_end();


//User list start
function userListsListUser($userId, $userUsername)
{
    echo
    '
            <!-- oneUser start -->
            <div class="mt-1 userList" style="">
                <div class="row" style="width: 100%; margin: 0;">
                    <span class="col-8">
                        <p class="m-0 p-1 col">[ '.$userId.' ] '.$userUsername.'</p>
                    </span>
                    <span class="col-4 d-flex align-content-center flex-wrap">
                        <div class="row">
                            <span class="col-4">
                                <a href="#"><i class="bi bi-search"></i></a>
                            </span>
                            <span class="col-4">
                                <a href="/handlers/banUser.php?uid='.$userId.'"><i class="bi bi-hammer col"></i></a>
                            </span>
                            <span class="col-4">
                                <a href="/handlers/deleteUser.php?uid='.$userId.'"><i class="bi bi-trash"></i></a>
                            </span>
                        </div>
                    </span>
                </div>
            </div>
            <!-- oneUser end -->
    ';
}
function listAllUsers()
{
    $con = db_connection();

    $query = "SELECT uid, username FROM user;";
    $result = mysqli_query($con, $query);
    for($i = 0; $i < mysqli_num_rows($result); $i++)
    {
        $row = mysqli_fetch_assoc($result);
        userListsListUser($row["uid"], $row["username"]);
    }
}
//User list end

function bannedListListUser()
{

}
