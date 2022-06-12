<?php
include_once 'database.php';

if (count($_POST) > 0)
{
    $con = db_connection_knihy();

    $nazev = $_POST["nazev"];

    $query = "INSERT INTO smer(nazev) VALUES('" . $nazev . "');";

    mysqli_query($con, $query);
}

header("Location: index.php");