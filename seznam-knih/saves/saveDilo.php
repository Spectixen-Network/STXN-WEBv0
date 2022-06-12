<?php
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';

if (count($_POST) > 0)
{
    $con = db_connection_knihy();

    //------ ZAČÁTEK proměnných ------
    $nazevDila = test_input($_POST["nazev"]);
    $literarniDruh = test_input($_POST["literarniDruh"]);
    $literarniZanry = $_POST["literarniZanry"];
    $casoprostor = test_input($_POST["casoprostor"]);
    $strukturaDila = test_input($_POST["strukturaDila"]);
    $obsahDila = test_input($_POST["obsahDila"]);
    $forma = test_input($_POST["forma"]);
    if ($_POST["typ"][0] == "proza")
    {
        $jmenaPostav = test_input($_POST["postavyJmena"]);
        $typy = test_input($_POST["typy"]);
    }
    if ($_POST["typ"][0] == "poezie")
    {
        $figuryATropy = test_input($_POST["figuryTropy"]);
        $rymy = test_input($_POST["rymy"]);
        $rytmus = test_input($_POST["rytmus"]);
    }
    if ($_POST["typ"][0] == "drama")
    {
        $druhyPostav = test_input($_POST["postavyDruhy"]);
        $charakteristika = test_input($_POST["charakteristika"]);
    }
    $temaDila = test_input($_POST["temaDila"]);
    $vysvetlenyNazevDila = test_input($_POST["jazykoveProstredky"]);
    $jazykoveProstredky = test_input($_POST["jazykoveProstredky"]);
    $autor = test_input($_POST["autor"]);
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
        $insertIntoDiloZanr = "INSERT INTO dilo_zanr(dilo_id, zanr_id) VALUES('" . $diloID . "', '" . test_input($literarniZanry[$i]) . "');";
        mysqli_query($con, $insertIntoDiloZanr);
    }
}

header("Location: /seznam-knih/views/formDilo.php");