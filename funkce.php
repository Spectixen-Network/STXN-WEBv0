<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function validate_email($email)
{
    $email = test_input($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function db_connection()
{
    $db_info = json_decode(file_get_contents("else/database.json"), true);
    $connection = mysqli_init();
    $server = $db_info["db_ip"];
    $database = $db_info["db_name"];
    $db_username = $db_info["db_username"];
    $db_password = $db_info["db_password"];

    if (!mysqli_real_connect($connection, $server, $db_username, $db_password, $database))
    {
        die("Nepodařilo se připojit k databázi");
    }
    return $connection;
}
function email_exist($email)
{
    $connection = db_connection();
    $dotaz = "SELECT ? FROM ? WHERE email='" . $email . "'";
    $result = mysqli_query($connection, $dotaz);
    if (mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function username_exist($username)
{
    $connection = db_connection();
    $dotaz = "SELECT username FROM login WHERE username='" . $username . "'";
    $result = mysqli_query($connection, $dotaz);
    if (mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function uid_exist($uid)
{
    $connection = db_connection();
    $dotaz = "SELECT u_id FROM login WHERE u_id='" . $uid . "'";
    $result = mysqli_query($connection, $dotaz);
    if (mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function uid_from_username($username)
{
    $connection = db_connection();
    $username = test_input($username);
    $dotaz = "SELECT u_id FROM login WHERE username='" . $username . "';";
    $result = mysqli_query($connection, $dotaz);
    return mysqli_fetch_row($result)[0];
}
function username_from_uid($uid)
{
    $connection = db_connection();
    $uid = test_input($uid);
    $dotaz = "SELECT username FROM login WHERE u_id='" . $uid . "';";
    $result = mysqli_query($connection, $dotaz);
    return mysqli_fetch_row($result)[0];
}
function active_bar()
{
    $str = 'class="active"';
    $act = array("", "", "", "", "", "");
    switch ($_SESSION["page"])
    {
        case "/stx/index.php":
            $act[0] = $str;
            break;
        case "/stx/about.php":
            $act[2] = $str;
            break;
        case "/stx/games.php":
            $act[3] = $str;
            break;
        case "/stx/contact.php":
            $act[4] = $str;
            break;
        case "/stx/store.php":
            $act[5] = $str;
            break;
        default:
            $act[0] = "";
    }
    return $act;
}
function navbar_()
{
    $act = active_bar();
    echo '
        <nav>
        <div class="nav">
            <script>myFunction()</script>
            <section class="nav-container">
                <aside class="logo" href="index.php">
                    <a id="navlinks" href="index.php"><img src="images/SpectixenNetwork_logo_bez_pozadi_400x400.png">
                        <h1>Spectixen<br>Network</h1>
                    </a>
                </aside>
                <aside class="menu">
                    <div class="menu-content">
                        <aside class="navbarbuttons">
                            <ul>
                                <li><a ' . $act[0] . ' href="index.php">Home</a></li>
                                <li><a ' . $act[2] . ' href="about.php">About us</a></li>
                                <li><a ' . $act[3] . ' href="games.php">Games</a></li>
                                <li><a ' . $act[4] . ' href="contact.php">Contact</a></li>
                                <li><a ' . $act[5] . ' href="store.php">Store</a></li>
                            </ul>
                        </aside>
                        <a href="#" id="button-a">Login</a> | <a href="register.php" id="button-b">Register</a>
                        <script>
                            // Get the button, and when the user clicks on it, execute myFunction
                            document.getElementById("button-a").onclick = function() {
                                myFunction()
                            };
                            /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
                            function myFunction() {
                                document.getElementById("login-arrow").classList.toggle("show");
                                document.getElementById("login").classList.toggle("show");
                            }
                        </script>
                    </div>
                    <div class="arrow-up" id="login-arrow"></div>
                </aside>
                <div class="login-form" id="login">
                    <div class="form">
                        <h1>Log in</h1>
                        <form method="POST" action="handle.php" class="form_">
                            <input type="hidden" name="form" value="login">
                            <input type="text" name="username" value="" placeholder="Username" required><br>
                            <input type="password" name="password" placeholder="Password" value="" required><br>';
    if (isset($_SESSION["err"]))
    {
        echo '<p style="color: black; font-size: 0.75em; padding: 0 0 0 25px; margin: 5px 0" >' . $_SESSION["err"] . '</p> ';
    }
    echo '              <input class="loginbtn" type="submit" name="" value="Login"><br>
                        </form>
                    </div>
                    <h3><a href="fgpass.php">Forgot password?</a></h3>
                </div>
            </section>
            <div class="navbar-search_mode">
                <form method="GET" action="' . $_SERVER["SCRIPT_NAME"] . '">
                    <input type="hidden" name="sent" value="1">
                    <input id="search-box" type="search" name="UID" placeholder="Search" autocomplete="off" required>
                    <input id="search-button" type="submit" name="" value="Search">
                </form>
            </div>
            </div>
        </nav>
        ';
}
function navbar()
{
    echo '
        <nav class="sticky-top">
            <div class="container-fluid nav-bar-content ">
                <div class="navbar">
                    <a href="#" class="navbar-brand">
                        <img src="images/SpectixenNetwork_logo_bez_pozadi_400x400.png" alt="" class="logo">
                        <span class="navbar-text">STXN</span>
                    </a>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Test 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Test 2</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Test 3</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Test 4</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Test 5</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    ';
}

function navbar_logedin()
{
    $connection = db_connection();
    $username = $_SESSION["username"];
    $dotaz = "SELECT U_ID, img_name FROM login WHERE username='" . $username . "';";
    $vysledek = mysqli_query($connection, $dotaz);
    $row = mysqli_fetch_row($vysledek);
    $uid = $row[0];
    $avatar = $row[1];
    $redirect = "window.location = 'profile.php?UID='" . $uid . ""; //"window.location = 'profile.php'"; // 
    $redirect2 = "window.location = 'friends.php'"; //"window.location = 'profile.php'"; // 
    $act = active_bar();

    echo '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <nav>
    <div class="nav">
        <section class="nav-container">
            <aside class="logo" href="index.php">
                <a id="navlinks" href="index.php">
                    <img src="images/SpectixenNetwork_logo_bez_pozadi_400x400.png">
                    <h1>Spectixen<br>Network</h1>
                </a>
            </aside>
            <aside class="menu">
                <div class="menu-content">
                    <aside class="navbarbuttons">
                        <ul>
                            <li><a ' . $act[0] . ' href="index.php">Home</a></li>
                            <li><a ' . $act[2] . ' href="about.php">About us</a></li>
                            <li><a ' . $act[3] . ' href="games.php">Games</a></li>
                            <li><a ' . $act[4] . ' href="contact.php">Contact</a></li>
                            <li><a ' . $act[5] . ' href="store.php">Store</a></li>
                            <button class="notification-button" id="notification-button-id"><i class="fa fa-bell" style="font-size:24px; padding-right: 5px"></i>
                            <span class="';
    if (has_friend_requests())
    {
        echo "show-notification-badge";
    }
    echo                        ' notification-badge" id="notification-badge-id">1</span>
                            <div class="not">
                                        <div class="not2 " id="notify">';
    if (has_friend_requests())
    {
        vypis_friend_requests();
    }
    else
    {
        echo '<p style="margin: 0;">Nothin` here</p>';
    }
    echo '                                    </div>
                                    </div>
                            </button>
                            <script>
                                // Get the button, and when the user clicks on it, execute myFunction
                                document.getElementById("notification-button-id").onclick = function() {
                                    FuctionDeleteNotificationBadge()
                                };
                                /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
                                function FuctionDeleteNotificationBadge() {
                                    document.getElementById("notification-badge-id").classList.remove("show-notification-badge");
                                    document.getElementById("notify").classList.toggle("show_notify");
                                }
                            </script>
                                <ul>
                                    <div class="loggedin-arrow-up-box" id="loggedin-arrow-up-box-id">
                                        <div class="loggedin-arrow-up " id="loggedin-arrow">
                                        </div>

                                        <div class="loggedin-logout-button">
                                            <div style="padding: 20px 0 5px 0">
                                                <form method="GET" action="profile.php">
                                                    <input type="hidden" name="UID" value="' . $uid . '">
                                                    <input type="submit" value="Profile" onclick="' . $redirect . ';">
                                                </form>
                                                <form method="POST" action="friends.php">
                                                    <input type="submit" value="Friends">
                                                </form>
                                                <form method="POST" action="handle.php">
                                                    <input type="hidden" name="form" value="logout">
                                                    <input type="submit" value="Log out">
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <a id="button-logedin"> ' . $username . ' </a>
                                    <img src="images/avatars/' . $avatar . '" alt="♥ " class="avatar " id="button-loggedin-img">
                                    <script>
                                        // Get the button, and when the user clicks on it, execute myFunction
                                        document.getElementById("button-logedin").onclick = function() {
                                            myFunction()
                                        };
                                        document.getElementById("button-loggedin-img").onclick = function() {
                                            myFunction()
                                        };
                                        /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
                                        function myFunction() {
                                            document.getElementById("loggedin-arrow-up-box-id").classList.toggle("show");
                                        }
                                    </script>
                            </ul>
                        </ul>
                    </aside>
                </div>
            </aside>
        </section>
        <div class="navbar-search_mode">
                <form method="GET" action="' . $_SERVER["SCRIPT_NAME"] . '">
                    <input type="hidden" name="sent" value="1">
                    <input id="search-box" type="search" name="UID" placeholder="Search" autocomplete="off" required>
                    <input id="search-button" type="submit" name="" value="Search">
                </form>
            </div>
        </div>
    </nav>
    ';
}
function vypis_navbar()
{
    if (isset($_SESSION["login"]))
    {
        if ($_SESSION["login"])
        {
            navbar_logedin();
        }
        else
        {
            navbar();
        }
    }
    else
    {
        navbar();
    }
}

function vypis_html_start($title, $css_file_pathname_1, $css_file_pathname_2 = "", $css_file_pathname_3 = "")
{
    search_profile_handle();
    echo '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" href="images/SpectixenNetwork_logo_bez_pozadi_400x400.png" type="image/x-icon">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <link rel="stylesheet" href="' . $css_file_pathname_1 . '.css">';
    if ($css_file_pathname_2 != "")
    {
        echo '<link rel="stylesheet" href="' . $css_file_pathname_2 . '.css">';
    }
    if ($css_file_pathname_3 != "")
    {
        echo '<link rel="stylesheet" href="' . $css_file_pathname_3 . '.css">';
    }

    echo '
            <title>Spectixen Network | ' . $title . '</title>
        </head>
        
        <body>
    ';
}
function vypis_html_end()
{
    echo '
            </body>
        </html>
    ';
}
function curr_time_formatted()
{
    return date("Y-m-d H:i:s", time());
}
function search_profile_handle()
{
    if (isset($_GET["UID"]) && isset($_GET["sent"]))
    {
        if ($_GET["sent"] == "1")
        {
            $search = test_input($_GET["UID"]);
            $_GET["send"] = "0";
            if (is_numeric($search))
            {
                if (uid_exist($search))
                {
                    header("Location: profile.php?UID=" . $search);
                }
                else
                {
                    if (username_exist($search))
                    {
                        $uid = uid_from_username($search);
                        header("Location: profile.php?UID=" . $uid);
                    }
                    else
                    {
                        $_SESSION["profile-err"] = '<h1 class="profile-err_message">User with this UID, or Username does not exist!</h1>';
                        header("Location: profile.php");
                    }
                }
            }
            else
            {
                if (username_exist($search))
                {
                    $uid = uid_from_username($search);
                    header("Location: profile.php?UID=" . $uid);
                }
                else
                {
                    $_SESSION["profile-err"] = '<h1 class="profile-err_message">User with this Username does not exist!</h1>';
                    header("Location: profile.php");
                }
            }
        }
    }
}
function reset_session_err()
{
    if (isset($_SESSION["page"]))
    {
        if (!($_SESSION["page"] == $_SERVER["SCRIPT_NAME"]))
        {
            $_SESSION["err"] = "";
        }
    }
    if ($_SERVER["SCRIPT_NAME"] == "/stx/profile.php")
    {
        if (isset($_SESSION["UID"]))
        {
            $_SESSION["page"] = $_SERVER["SCRIPT_NAME"] . '?UID=' . $_SESSION["UID"];
        }
        else
        {
            $_SESSION["page"] = $_SERVER["SCRIPT_NAME"];
        }
    }
    else
    {
        $_SESSION["page"] = $_SERVER["SCRIPT_NAME"];
    }
}
function get_profile_info_assoc($uid)
{
    $con = db_connection();
    $dotaz = "SELECT * FROM login WHERE u_id='" . $uid . "';";
    $result = mysqli_query($con, $dotaz);
    return mysqli_fetch_assoc($result);
}
function has_friend_requests()
{
    $con = db_connection();
    $dotaz = "SELECT from_uid FROM friend_request WHERE to_uid='" . $_SESSION["UID"] . "';";
    $result = mysqli_query($con, $dotaz);

    if (mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else return false;
}
function get_friend_requests()
{
    $con = db_connection();
    $dotaz = "SELECT from_uid FROM friend_request WHERE to_uid='" . $_SESSION["UID"] . "';";
    return mysqli_query($con, $dotaz);
}

function vypis_friend_requests()
{
    $requsets = get_friend_requests();
    for ($i = 0; $i < mysqli_num_rows($requsets); $i++)
    {
        $requset = mysqli_fetch_assoc($requsets);
        $info = get_profile_info_assoc($requset["from_uid"]);
        vypis_friend_requests_content($info["username"], $info["U_ID"], $info["img_name"]);
    }
}
function already_friends($uid1, $uid2)
{
    $con = db_connection();
    $dotaz_1 = "SELECT * FROM friends WHERE U_ID1='" . $uid1 . "' AND U_ID2='" . $uid2 . "';";
    $dotaz_2 = "SELECT * FROM friends WHERE U_ID1='" . $uid2 . "' AND U_ID2='" . $uid1 . "';";
    $result_1 = mysqli_query($con, $dotaz_1);
    $result_2 = mysqli_query($con, $dotaz_2);
    if ((mysqli_num_rows($result_1) > 0) || (mysqli_num_rows($result_2) > 0))
    {
        return true;
    }
    else return false;
}
function already_requested($from_uid, $to_uid)
{
    $con = db_connection();
    $dotaz_1 = "SELECT * FROM friend_request WHERE from_uid='" . $from_uid . "' AND to_uid='" . $to_uid . "';";
    $dotaz_2 = "SELECT * FROM friend_request WHERE from_uid='" . $to_uid . "' AND to_uid='" . $from_uid . "';";
    $result_1 = mysqli_query($con, $dotaz_1);
    $result_2 = mysqli_query($con, $dotaz_2);
    if ((mysqli_num_rows($result_1) > 0) || (mysqli_num_rows($result_2) > 0))
    {
        return true;
    }
    else return false;
}
function vypis_friend_requests_content($username, $from_id, $avatar)
{
    echo '
    <div class="navbar-request-content">
        <div class="request">
            <img class="request-img" src="images/avatars/' . $avatar . '" alt="navbar-request-icon">
            <p class="request-username">' . $username . '</p>
            <div class="request-buttons">
                <form method="POST" action="handle.php">
                    <input type="hidden" name="FROM" value="' . $from_id . '">
                    <input type="hidden" name="form" value="handle-friend-request">
                    <input type="hidden" name="action" value="accept">
                    <input class="request-gutton" type="submit" value="accpet">
                </form>
                <form method="POST" action="handle.php">
                    <input type="hidden" name="FROM" value="' . $from_id . '">
                    <input type="hidden" name="form" value="handle-friend-request">
                    <input type="hidden" name="action" value="reject">
                    <input class="request-gutton" type="submit" value="reject">
                </form>
            </div>
        </div>
    </div> 
    ';
}
function get_friends($uid)
{
    $con = db_connection();
    $dotaz_1 = "SELECT U_ID2, friends_since FROM friends WHERE U_ID1 = '" . $uid . "';";
    $dotaz_2 = "SELECT U_ID1, friends_since FROM friends WHERE U_ID2 = '" . $uid . "';";

    $result_1 = mysqli_query($con, $dotaz_1);
    $result_2 = mysqli_query($con, $dotaz_2);
    $num_1 = mysqli_num_rows($result_1);
    $num_2 = mysqli_num_rows($result_2);
    $num = $num_1 + $num_2;
    if ($num > 0)
    {
        $uids = array($num);
        if ($num_1 > 0)
        {
            for ($i = 0; $i < $num_1; $i++)
            {
                $uids[$i] = mysqli_fetch_row($result_1);
            }
        }
        if ($num_2 > 0 && $num_1 > 0)
        {
            for ($i = $num_1; $i < ($num_1 + $num_2); $i++)
            {
                $uids[$i] = mysqli_fetch_row($result_2);
            }
        }
        if ($num_2 > 0 && $num_1 == 0)
        {
            for ($i = 0; $i < ($num_1 + $num_2); $i++)
            {
                $uids[$i] = mysqli_fetch_row($result_2);
            }
        }
        return $uids;
    }
    else
    {
        return false;
    }
}
function num_of_friends($uid)
{
    $con = db_connection();
    $dotaz_1 = "SELECT U_ID2, friends_since FROM friends WHERE U_ID1 = '" . $uid . "';";
    $dotaz_2 = "SELECT U_ID1, friends_since FROM friends WHERE U_ID2 = '" . $uid . "';";

    $result_1 = mysqli_query($con, $dotaz_1);
    $result_2 = mysqli_query($con, $dotaz_2);
    $num_1 = mysqli_num_rows($result_1);
    $num_2 = mysqli_num_rows($result_2);
    $num = $num_1 + $num_2;

    return $num;
}
function some_text()
{
    echo '<p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore voluptate?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim, nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo
        blanditiis. Voluptas asperiores corrupti rerum eos totam eum delectus. Quia esse voluptatem tempore
        voluptate?Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, ipsa. Tenetur earum explicabo in enim,
        nemo

    </p>';
}
