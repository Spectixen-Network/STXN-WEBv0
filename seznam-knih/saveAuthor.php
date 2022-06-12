<?php
include_once 'database.php';

if (count($_POST) > 0)
{
    $jmenoPrijmeni = explode(" ", $_POST["jmenoPrijmeni"]);
    $jmeno = $jmenoPrijmeni[0];
    $prijmeni = $jmenoPrijmeni[1];
    $litSmer = $_POST["smery"];
    $zanry = $_POST["zanry"];
    $skupina = $_POST["skupina"];

    $con = db_connection_knihy();
    $insertIntoAutor = "INSERT INTO autor(jmeno, prijmeni, skupina) VALUES('" . $jmeno . "', '" . $prijmeni . "', '" . $skupina . "')";
    mysqli_query($con, $insertIntoAutor);
    $autorIDQuery = "SELECT id FROM autor WHERE jmeno='" . $jmeno . "' AND prijmeni='" . $prijmeni . "';";
    $autorID = mysqli_fetch_row(mysqli_query($con, $autorIDQuery))[0];
    for ($i = 0; $i < count($litSmer); $i++)
    {
        $insertIntoAutorSmer = "INSERT INTO autor_smer(autor_id, smer_id) VALUES('" . $autorID . "', '" . $litSmer[$i] . "');";
        mysqli_query($con, $insertIntoAutorSmer);
    }
    for ($i = 0; $i < count($zanry); $i++)
    {
        $insertIntoAutorZanr = "INSERT INTO autor_zanr(autor_id, zanr_id) VALUES('" . $autorID . "', '" . $zanry[$i] . "');";
        mysqli_query($con, $insertIntoAutorZanr);
    }
    header("Location: index.php");
}