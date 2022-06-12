<?php
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';

if (count($_POST) > 0)
{
    $info = "";
    $skupina = "";
    $jmeno = test_input($_POST["jmeno"]);
    $prijmeni = test_input($_POST["prijmeni"]);
    $litSmer = $_POST["smery"];
    $info = test_input($_POST["info"]);
    $skupina = test_input($_POST["skupina"]);

    $con = db_connection_knihy();
    $insertIntoAutor = "INSERT INTO autor(jmeno, prijmeni, skupina, info) VALUES('" . $jmeno . "', '" . $prijmeni . "', '" . $skupina . "', '" . $info . "')";
    mysqli_query($con, $insertIntoAutor);
    $autorIDQuery = "SELECT id FROM autor WHERE jmeno='" . $jmeno . "' AND prijmeni='" . $prijmeni . "';";
    $autorID = mysqli_fetch_row(mysqli_query($con, $autorIDQuery))[0];
    for ($i = 0; $i < count($litSmer); $i++)
    {
        $insertIntoAutorSmer = "INSERT INTO autor_smer(autor_id, smer_id) VALUES('" . $autorID . "', '" . test_input($litSmer[$i]) . "');";
        mysqli_query($con, $insertIntoAutorSmer);
    }
    header("Location: /seznam-knih/views/formAutor.php");
}