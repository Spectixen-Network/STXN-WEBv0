<?php
include_once 'database.php';

if (count($_POST) > 0)
{
    $con = db_connection_knihy();

    //------ ZAČÁTEK proměnných ------
    $nazevDila = $_POST["nazev"];
    $literarniDruh = $_POST["literarniDruh"];
    $literarniZanry = $_POST["literarniZanry"];
    $casoprostor = $_POST["casoprostor"];
    $strukturaDila = $_POST["strukturaDila"];
    $obsahDila = $_POST["obsahDila"];
    $forma = $_POST["forma"];
    if ($_POST["typ"][0] == "proza")
    {
        $jmenaPostav = $_POST["postavyJmena"];
        $typy = $_POST["typy"];
    }
    if ($_POST["typ"][0] == "poezie")
    {
        $figuryATropy = $_POST["figuryTropy"];
        $rymy = $_POST["rymy"];
        $rytmus = $_POST["rytmus"];
    }
    if ($_POST["typ"][0] == "drama")
    {
        $druhyPostav = $_POST["postavyDruhy"];
        $charakteristika = $_POST["charakteristika"];
    }
    $temaDila = $_POST["temaDila"];
    $vysvetlenyNazevDila = $_POST["jazykoveProstredky"];
    $jazykoveProstredky = $_POST["jazykoveProstredky"];
    $autor = $_POST["autor"];
    //------ KONEC proměnných ------

    //------ ZAČÁTEK dotazů ------
    if ($_POST["typ"][0] == "proza")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, jmena_postav, typy, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $jmenaPostav . "', '" . $typy . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "');";
    }
    if ($_POST["typ"][0] == "poezie")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, figury_a_tropy, rymy, rytmus, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $figuryATropy . "', '" . $rymy . "', '" . $rytmus . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "');";
    }
    if ($_POST["typ"][0] == "drama")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, druhy_postav, charakteristika, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $druhyPostav . "', '" . $charakteristika . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "');";
    }
    mysqli_query($con, $insertIntoDilo);
    $getDiloID = "SELECT id FROM dilo WHERE nazev='" . $nazevDila . "';";
    $diloID = mysqli_fetch_row(mysqli_query($con, $getDiloID))[0];

    for ($i = 0; $i < count($literarniZanry); $i++)
    {
        $insertIntoDiloZanr = "INSERT INTO dilo_zanr(dilo_id, zanr_id) VALUES('" . $diloID . "', '" . $literarniZanry[$i] . "');";
        mysqli_query($con, $insertIntoDiloZanr);
    }
}

header("Location: index.php");