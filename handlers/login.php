<?php
session_start();
include '../funkce.php';

$page = $_SESSION["PAGE"];
$username = test_input($_POST["username"]);
$password = hash("sha256", test_input($_POST["pswd"]));

if (username_exist($username))
{
    $con = db_connection();
    $query = "SELECT uid FROM user WHERE username='" . $username . "' AND password='" . $password . "'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0)
    {
        $_SESSION["USERNAME"] = $username;
        $_SESSION["UID"] = mysqli_fetch_row($result)[0];
        if (is_banned($_SESSION["UID"]))
        {
            header("Location: /youHaveBeenBanned.php");
            die();
        }
        header("Location: " . $page);
        die();
    }
    else
    {
        header("Location: " . $_SESSION["PAGE"]);
        die();
    }
}
else
{
    header("Location: " . $_SESSION["PAGE"]);
    die();
}