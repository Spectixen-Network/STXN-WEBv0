<?php
function test_input($data): string
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
function db_connection(): mysqli
{
    $db_info = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/else/database.json'), true);
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
function email_exist($email): bool
{
    $connection = db_connection();
    $dotaz = "SELECT email FROM user WHERE email='" . $email . "'";
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
function username_exist($username): bool
{
    $connection = db_connection();
    $dotaz = "SELECT username FROM user WHERE username='" . $username . "'";
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
function uid_exist($uid): bool
{
    $connection = db_connection();
    $dotaz = "SELECT uid FROM user WHERE uid='" . $uid . "'";
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
function uid_from_username($username): int
{
    $connection = db_connection();
    $username = test_input($username);
    $dotaz = "SELECT uid FROM user WHERE username='" . $username . "';";
    $result = mysqli_query($connection, $dotaz);
    return mysqli_fetch_row($result)[0];
}
function username_from_uid($uid): string
{
    $connection = db_connection();
    $uid = test_input($uid);
    $dotaz = "SELECT username FROM user WHERE uid='" . $uid . "';";
    $result = mysqli_query($connection, $dotaz);
    return mysqli_fetch_row($result)[0];
}
function navbar_profile_image(): string
{
    $con = db_connection();
    $query = "SELECT image_path FROM user WHERE username='" . $_SESSION["USERNAME"] . "'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_array($result)[0];
}
function image_from_id($id): string
{
    $con = db_connection();
    $query = "SELECT image_path FROM user WHERE uid='" . $id . "'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_array($result)[0];
}
function is_admin($uid): bool
{
    $con = db_connection();
    $query = "SELECT admin FROM user WHERE uid='" . $uid . "'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_array($result)[0];
}
function is_banned($uid): bool
{
    $con = db_connection();
    $query = "SELECT uid FROM banneduser WHERE uid='" . $uid . "'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function nav(): void
{
    if (isset($_SESSION["USERNAME"]) && isset($_SESSION["UID"]))
    {
        navbar_logged();
    }
    else
    {
        navbar();
    }
}
function navbar(): void
{
    echo '
        <nav class="sticky-top">
            <div class="container-fluid nav-bar-content" id="nav-bar">
                <div class="navbar">
                    <a href="/" class="navbar-brand">
                        <img src="/images/system/SpectixenNetwork_logo_bez_pozadi_400x400.png" alt="" class="logo">
                        <span class="navbar-text">STXN</span>
                    </a>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a href="/index.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/creators.php" class="nav-link">Creators</a>
                        </li>
                        <li class="nav-item">
                            <a href="/car/roadTrip.php" class="nav-link">Car</a>
                        </li>
                        <button type="button" id="loginButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Log In
                        </button>
                    </ul>
                </div>
            </div>
            <!-- LogIn Modal -->
            <div class="modal fade" id="loginModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Login Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Log In</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Login Modal body -->
                        <div class="container">
                            <form action="/handlers/login.php" class="was-validated" method="POST">
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                                    <label for="username" class="form-label">Username:</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-floating mt-3 mb-3">
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                                    <label for="pwd" class="form-label">Password:</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="remember"> Remember me (WIP)
                                    </label>
                                </div>
                                <button id="loginSubmit" type="submit" class="btn btn-success">Log In</button>
                                <button id="loginRegister" type="button" data-bs-dismiss="modal" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Modal End --->

            <!-- Regiser Modal Start --->
            <div class="modal fade" id="registerModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Register Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Register</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Register Modal body -->
                        <div class="container">
                            <form action="/handlers/register.php" class="was-validated" method="POST">
                                <div class="form-floating mt-3 mb-3">

                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                                    <label for="username" class="form-label">Username:</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
                                    <label for="username" class="form-label">Email:</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-floating mt-3 mb-3">
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                                    <label for="pwd" class="form-label">Password:</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="termsofservice" required>Have
                                        you read <a href="#" title="Terms of Service" data-bs-toggle="TOSpopover" data-bs-placement="bottom" data-content="TOSPopoverContent" data-bs-content="To bych taky chtěl vedět :\')."><mark id="termsOfServiceCheckbox">Terms of Service</mark></a>?
                                    </label>
                                </div>
                                <button id="registerSubmit" type="submit" class="btn btn-success">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Register Modal end --->
        </nav>

        <!-- TOS Popover --->
        <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll(\'[data-bs-toggle="TOSpopover"]\'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
        </script>
        <!-- TOS Popover END --->
    ';
}
function navbar_logged(): void
{
    echo
    '
        <nav class="sticky-top">
            <div class="container-fluid nav-bar-content" id="nav-bar">
                <div class="navbar">
                    <a href="/" class="navbar-brand">
                        <img src="/images/system/SpectixenNetwork_logo_bez_pozadi_400x400.png" alt="" class="logo">
                        <span class="navbar-text">STXN</span>
                    </a>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a href="/index.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/fileManager.php?uid=' . $_SESSION["UID"] . '" class="nav-link">File manager</a>
                        </li>
                        <li class="nav-item">
                            <a href="/calendar.php" class="nav-link">Calendar</a>
                        </li>
                        <li class="nav-item">
                            <a href="/creators.php" class="nav-link">Creators</a>
                        </li>
                        <li class="nav-item">
                            <a href="/car/roadTrip.php" class="nav-link">Car</a>
                        </li>
                        ';
    if (is_admin($_SESSION["UID"]))
    {
        echo
        '
            <li class="nav-item">
                <!--<a href="/adminPanel/dashboard.php" class="nav-link">Dashboard</a>-->
                <a href="/adminPanel/users.php" class="nav-link">Users</a>
            </li>
        ';
    }
    echo '
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" id="dropdownButton">
                                <img src="/user/' . $_SESSION["UID"] . "/" . navbar_profile_image() . '" width="30" height="30" class="rounded-circle">
                            </button>

                            <ul class="dropdown-menu" id="dropdownMenuList">
                                <div class="container">
                                   <!-- <li id="dropdownMenuContent" <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes" checked>
                                        <label class="form-check-label" for="mySwitch">Dark mode</label>
                                    </li>
                                </div>
                                <li><a class="dropdown-item" id="dropdownMenuContent" href="/profile.php"><i class="bi bi-person"></i>  Profile</a></li>
                                <li><a class="dropdown-item" id="dropdownMenuContent" href="/settings.php"><i class="bi bi-gear"></i>  Settings</a></li> -->
                                <li>
                                    <hr class="dropdown-divider"><a class="dropdown-item" id="dropdownMenuContent" href="/handlers/logout.php"><i class="bi bi-box-arrow-in-right"></i>  Log out</a></hr>
                                </li>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    ';
}
function banner($name): void
{
    $delka = strlen($name);
    $text = str_split($name, 1);

    echo
    '
        <div id="banner" class="container-fluid">
            <div class="wavy">
                <div class="container d-flex" style="justify-content: center;">';
    for ($i = 0; $i < $delka; $i++)
    {
        if (strcmp($text[$i], " "))
        {
            echo '<span style=" --i:' . $i . '">' .  $text[$i] . '</span>';
        }
        else
        {
            echo '<span style=" --i:' . $i . '"> </span>';
        }
    }
    echo '
                </div>
            </div>
        </div>
    ';

    echo
    '
        <script>
            let vyska_prvku = document.getElementById("banner").clientHeight;
            var x = 0;
            window.addEventListener("scroll", (event) => {
                let scroll = this.scrollY;
                let opacity = scroll / vyska_prvku;
                if ((opacity >= 1) && (x == 0)) {
                    opacity = 1;
                    x = 1;
                    document.getElementById("nav-bar").style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
                } else {
                    document.getElementById("nav-bar").style.backgroundColor = "rgba(0, 0, 0, "+ opacity + ")";
                }
            });
        </script>
    ';
}
function html_start($title, $css_file_pathname_1, $css_file_pathname_2 = "", $css_file_pathname_3 = "", $css_file_pathname_4 = "", $css_file_pathname_5 = "", $css_file_pathname_6 = "", $css_file_pathname_7 = "", $css_file_pathname_8 = ""): void
{
    $_SESSION["PAGE"] = $_SERVER["SCRIPT_NAME"];
    if ($_SERVER["PHP_SELF"] != "/fileManager.php")
    {
        unset($_SESSION["FILE_MANAGER_UID"]);
    }
    echo '

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/images/system/SpectixenNetwork_logo_bez_pozadi_400x400.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
 <!--       <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> -->
        <script src="https://kit.fontawesome.com/2f73e7245a.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/' . $css_file_pathname_1 . '.css">';
    if ($css_file_pathname_2 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_2 . '.css">';
    }
    if ($css_file_pathname_3 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_3 . '.css">';
    }
    if ($css_file_pathname_4 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_4 . '.css">';
    }
    if ($css_file_pathname_5 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_5 . '.css">';
    }
    if ($css_file_pathname_6 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_6 . '.css">';
    }
    if ($css_file_pathname_7 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_7 . '.css">';
    }
    if ($css_file_pathname_8 != "")
    {
        echo '<link rel="stylesheet" href="/' . $css_file_pathname_8 . '.css">';
    }

    echo '
            <title>Spectixen Network | ' . $title . '</title>
        </head>
        
        <body>
    ';
}
function html_end(): void
{
    echo '
        </body>
    </html>
    ';
}
function curr_time_formatted(): string
{
    return date("Y-m-d H:i:s", time());
}
function curr_date_to_DB(): string
{
    return date("Y-m-d", time());
}
function date_to_DB($dateTimestamp_strtotime): string
{
    return date("Y-m-d", $dateTimestamp_strtotime);
}
function date_formatted_string(string $dateFromDB): string
{
    $date = explode("-", $dateFromDB);
    $format = $date[2] . "." . $date[1] . "." . $date[0];
    return $format;
}
function date_formatted_timestamp(string $dateFromDB): int
{
    $date = explode("-", $dateFromDB);
    $format = $date[2] . "." . $date[1] . "." . $date[0];
    return strtotime($format);
}
function errorModal(): void
{
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
                            <div class="form-floating mt-3 mb-3">
                      <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" onclick="toggleMakeFolder();" id="mySwitch" name="makeFolder" value="Yes">
                                    <label class="form-check-label" for="mySwitch">Make folder</label>
                                </div>
                                <div class="form-floating mt-3 mb-3 showNone" id="folderNameInput">
                                    <input type="text" class="form-control" placeholder="Some text" name="folderToMake" id="folderName">
                                    <label for="folderToMake">Folder Name</label>
                                </div>
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
function footer(): void
{
    echo
    '
    <footer>
        <div class="footer-content">
            <h3>Spectixen Network</h3>
            
            <ul class="footer-links">
                <li><a href="#"><i class="fa fa-github"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy;2022 Spectixen Network. Footer created by <span>Yura</span></p>
        </div>
    </footer>
    ';
}
function some_text(): void
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
function svg_image(): void
{
    echo
    '
        <svg style="height: 100%; width: 100%;" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" width="1920" height="1080" viewBox="0 0 1920 1080">
            <defs>
                <style>
                .cls-1 {
                    fill: #c300ff;
                    fill-rule: evenodd;
                }
                </style>
            </defs>
            <g id="Artboard_1" data-name="Artboard 1">
                <image x="795" y="199" width="331" height="401"
                    xlink:href="data:img/png;base64,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" />
                <path id="Spectixen_Network" data-name="Spectixen Network" class="cls-1"
                    d="M300.344,1599.38q9,9,32.375,9,13.313,0,22.063-3.84a30.478,30.478,0,0,0,13.625-11.28,29.065,29.065,0,0,0,4.875-16.25,25.741,25.741,0,0,0-3.656-13.56q-3.657-6.06-11.688-10.16t-26.594-8.09q-7.5-1.56-9.5-3.38a5.094,5.094,0,0,1-2.062-3.94,6.414,6.414,0,0,1,2.5-5.09q2.5-2.085,7.437-2.09,6,0,9.407,2.81t4.468,9l26.688-1.56q-1.75-14.25-10.969-20.78t-26.781-6.54q-14.313,0-22.531,3.6a27.152,27.152,0,0,0-12.313,9.87,24.047,24.047,0,0,0-4.094,13.35,22.359,22.359,0,0,0,8,17.68q7.936,6.945,26.563,11.13,11.375,2.505,14.5,5.31a8.168,8.168,0,0,1-.156,12.97q-3.282,2.85-9.344,2.84-8.125,0-12.5-5.56-2.688-3.435-3.563-10l-26.937,1.69Q291.343,1590.385,300.344,1599.38Zm111.313,32.69v-31.69a25.412,25.412,0,0,0,8.656,5.94,27.89,27.89,0,0,0,10.719,2,25.937,25.937,0,0,0,20.062-8.72q7.936-8.715,7.938-25.28,0-15-7.281-25.19t-20.594-10.18a26.049,26.049,0,0,0-12.313,2.93q-4.125,2.19-9.062,8.38v-9.81H385.969v91.62h25.688Zm3.062-70.62a10.253,10.253,0,0,1,8.125-3.82,9.565,9.565,0,0,1,7.625,3.79q3.125,3.78,3.125,11.84,0,8.745-3,12.41a9.272,9.272,0,0,1-7.437,3.65,10.619,10.619,0,0,1-8.375-3.81q-3.314-3.81-3.313-11.69Q411.469,1565.255,414.719,1561.45Zm130.188,15.62q0-13.125-4.313-21.31a29.08,29.08,0,0,0-12.562-12.5q-8.25-4.32-22.5-4.31-17.564,0-27.531,9.62t-9.969,25.19A35.628,35.628,0,0,0,473,1592.79a30.436,30.436,0,0,0,12.531,11.81q7.561,3.72,20.75,3.72,15.188,0,23.312-4.34t13.875-14.35l-25.062-2.31a16.76,16.76,0,0,1-4.438,4.19,14.452,14.452,0,0,1-7.125,1.87,12.041,12.041,0,0,1-9.625-4.31q-2.625-3-3.312-9.12h51v-2.88Zm-50.938-9.31q0.624-5.94,2.938-8.94a12.453,12.453,0,0,1,18.156-1.62q3.219,3.18,3.969,10.56H493.969ZM601,1588.7a13.577,13.577,0,0,1-8.407,2.56,12.775,12.775,0,0,1-9.875-4.24q-3.876-4.245-3.875-12.42,0-9.165,3.907-13.69a12.842,12.842,0,0,1,10.218-4.53,13.268,13.268,0,0,1,7.969,2.16,11.086,11.086,0,0,1,4.094,6.41l23.937-3.19q-3.438-11.19-11.968-17t-24.782-5.81q-11.625,0-19.062,3.06a32.1,32.1,0,0,0-9.125,5.9,30.808,30.808,0,0,0-7,8.96q-3.5,6.81-3.5,17.05,0,9.8,2.875,15.73a32.18,32.18,0,0,0,7.937,10.34,30.958,30.958,0,0,0,12.094,6.37,66.574,66.574,0,0,0,17.594,1.96q10.936,0,18.031-3.06a30.532,30.532,0,0,0,11.656-8.59,33.966,33.966,0,0,0,6.563-13.1l-24.188-2.75A15.3,15.3,0,0,1,601,1588.7Zm46.156-60.44v12.19h-9.375v18.62h9.375v23.35q0,11.1,2.156,16.07a14.877,14.877,0,0,0,6.656,7.4q4.5,2.43,14,2.43a83.138,83.138,0,0,0,17.625-2.06l-1.875-17.56a27.958,27.958,0,0,1-7.875,1.62q-3.126,0-4.375-2.12-0.813-1.365-.812-5.61v-23.52h14v-18.62h-14V1515.2Zm52.562,4.25h25.438V1515.2H699.719v17.31Zm0,74.31h25.438v-66.37H699.719v66.37Zm58.858-34.75-24.108,34.75h27.563l14.406-21.37,12.281,21.37h29.688l-24.268-34.75,22.643-31.62H788.719l-12.281,18.5-10.531-18.5H735.719Zm139.705,5q0-13.125-4.313-21.31a29.08,29.08,0,0,0-12.562-12.5q-8.25-4.32-22.5-4.31-17.564,0-27.531,9.62t-9.969,25.19a35.628,35.628,0,0,0,4.969,19.03,30.436,30.436,0,0,0,12.531,11.81q7.561,3.72,20.75,3.72,15.188,0,23.312-4.34t13.875-14.35l-25.062-2.31a16.76,16.76,0,0,1-4.438,4.19,14.452,14.452,0,0,1-7.125,1.87,12.041,12.041,0,0,1-9.625-4.31q-2.625-3-3.312-9.12h51v-2.88Zm-50.938-9.31q0.624-5.94,2.938-8.94a12.453,12.453,0,0,1,18.156-1.62q3.219,3.18,3.969,10.56H847.344Zm62.625,39.06h25.438v-31.87q0-9.06,2.875-12.57a9.252,9.252,0,0,1,7.5-3.5,8.258,8.258,0,0,1,6.5,2.6q2.311,2.6,2.312,8.84v36.5h25.563v-42.19q0-13.125-5.969-19.4t-16.531-6.28a28.375,28.375,0,0,0-13.25,2.84,35.271,35.271,0,0,0-10.75,9.47v-10.81H909.969v66.37Zm129.941,0h26.62v-50.31l34.31,50.31h26.69V1515.2h-26.69v50.69l-34.5-50.69h-26.43v91.62Zm178.43-29.75q0-13.125-4.31-21.31a29.049,29.049,0,0,0-12.56-12.5q-8.25-4.32-22.5-4.31-17.565,0-27.53,9.62t-9.97,25.19a35.656,35.656,0,0,0,4.97,19.03,30.434,30.434,0,0,0,12.53,11.81q7.56,3.72,20.75,3.72,15.18,0,23.31-4.34t13.88-14.35l-25.07-2.31a16.762,16.762,0,0,1-4.43,4.19,14.47,14.47,0,0,1-7.13,1.87,12.019,12.019,0,0,1-9.62-4.31q-2.625-3-3.32-9.12h51v-2.88Zm-50.93-9.31q0.615-5.94,2.93-8.94a12.457,12.457,0,0,1,18.16-1.62q3.225,3.18,3.97,10.56h-25.06Zm67.81-39.5v12.19h-9.38v18.62h9.38v23.35q0,11.1,2.16,16.07a14.83,14.83,0,0,0,6.65,7.4q4.5,2.43,14,2.43a83.226,83.226,0,0,0,17.63-2.06l-1.88-17.56a27.931,27.931,0,0,1-7.87,1.62q-3.135,0-4.38-2.12-0.81-1.365-.81-5.61v-23.52h14v-18.62h-14V1515.2Zm68.8,78.56h22.74l12.99-39.94,13.44,39.94h22.64l24.45-66.37h-24.44l-10.71,41.89-14.03-41.89h-22.99l-13.47,41.79L1304,1540.45h-24.59Zm110.45-6.62q9.87,8.115,25.87,8.12,17.94,0,28.1-9.78t10.15-25.09q0-13.635-8.18-22.94-10.2-11.565-30.13-11.56-17.43,0-27.69,9.84-10.245,9.84-10.25,25.03,0,16.32,12.13,26.38h0Zm17-39.47a11.508,11.508,0,0,1,9.19-4.28,11.073,11.073,0,0,1,8.81,4.22q3.555,4.215,3.56,12.84,0,9.255-3.53,13.44a11.78,11.78,0,0,1-18.06-.07q-3.6-4.245-3.6-13.12Q1427.84,1565.015,1431.47,1560.73Zm59.62,46.09h25.57v-22.25q0-15.93,3.93-21.75a8.8,8.8,0,0,1,7.75-4.12,19.99,19.99,0,0,1,7.13,1.87l7.87-18.12a26.745,26.745,0,0,0-12.31-3.5,14.966,14.966,0,0,0-9.03,2.65q-3.66,2.655-7.09,9.72v-10.87h-23.82v66.37Zm60.82,0h26v-17.25l9.58-9.36,13.44,26.61h28.66l-25.18-43.12,23.81-23.25h-31.31l-19,22.04V1515.2h-26v91.62Z"
                    transform="translate(0 -894)" />
            </g>
        </svg>
    ';
}
function isLoggedElseRedirect(): void
{
    if (!isset($_SESSION["UID"]))
    {
        header("Location: /index.php");
    }
}
// NOT MY FUNCTION
function GetDirectorySize($path): int
{
    $bytestotal = 0;
    $path = realpath($path);
    if ($path !== false && $path != '' && file_exists($path))
    {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object)
        {
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}