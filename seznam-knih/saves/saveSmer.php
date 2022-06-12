<?php
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';

if (count($_POST) > 0)
{
    $con = db_connection_knihy();

    $nazev = test_input($_POST["nazev"]);

    $query = "INSERT INTO smer(nazev) VALUES('" . $nazev . "');";

    mysqli_query($con, $query);
}

header("Location: index.php");