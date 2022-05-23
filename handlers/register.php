<?php
session_start();
include '../funkce.php';

$usernameErr = "";
$emailErr = "";

$con = db_connection();
$username = test_input($_POST["username"]);
$email = validate_email(test_input($_POST["email"]));
$password = hash("sha256", test_input($_POST["pswd"]));

if (username_exist($username))
{
    $emailErr = "Email already exists!";
}
if (email_exist($email))
{
    $usernameErr = "Username already exists!";
}

if ($emailErr === "" && $usernameErr === "")
{
    $query = "INSERT INTO user(username, password, email, image_path) VALUES('" . $username . "', '" . $password . "', '" . $email . "' , 'images/noavatar.png')";
    mysqli_query($con, $query);
    $_SESSION["USERNAME"] = $username;

    $query = "SELECT uid FROM user WHERE username='" . $username . "'";
    $uid = mysqli_fetch_row(mysqli_query($con, $query))[0];
    $_SESSION["UID"] = $uid;

    mkdir("../user/" . $uid);
    mkdir("../user/" . $uid . "/images");
    mkdir("../user/" . $uid . "/chats");
    mkdir("../user/" . $uid . "/files");
    copy("../images/noavatar.png", "../user/" . $uid . "/images/noavatar.png");

    header("Location: " . $_SESSION["PAGE"]);
    die();
}
else
{
    header("Location: " . $_SESSION["PAGE"]);
    die();
}