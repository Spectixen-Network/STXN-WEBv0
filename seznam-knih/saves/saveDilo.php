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
        $postavy = [
            "jmenoPostavy" => $_POST["jmenoPostavy"],
            "typPostavy" => $_POST["typPostavy"],
            "vlastnosti" => $_POST["vlastnosti"],
            "literarniTyp" => $_POST["literarniTyp"]
        ];
    }
    if ($_POST["typ"][0] == "poezie")
    {
        $figuryATropy = test_input($_POST["figuryTropy"]);
        $rymy = test_input($_POST["rymy"]);
        $rytmus = test_input($_POST["rytmus"]);
    }
    if ($_POST["typ"][0] == "drama")
    {
        $postavyD = [
            "jmenoPostavyD" => $_POST["jmenoPostavyD"],
            "typPostavyD" => $_POST["typPostavyD"],
            "vlastnostiD" => $_POST["vlastnostiD"],
            "literarniTypD" => $_POST["literarniTypD"],
            "charakteristikaD" => $_POST["charakteristikaD"]
        ];
    }
    $temaDila = test_input($_POST["temaDila"]);
    $vysvetlenyNazevDila = test_input($_POST["jazykoveProstredky"]);
    $jazykoveProstredky = test_input($_POST["jazykoveProstredky"]);
    $autor = test_input($_POST["autor"]);

    if (count($_POST["kompozice"]) > 1)
    {
        $kompozice = $_POST["kompozice"][0] . ", " . $_POST["kompozice"][1];
    }
    else
    {
        $kompozice = $_POST["kompozice"][0];
    }
    //------ KONEC proměnných ------

    //------ ZAČÁTEK dotazů ------
    if ($_POST["typ"][0] == "proza")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, typ, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id, kompozice) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $_POST["typ"][0] . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "', '" . $kompozice . "');";
    }
    if ($_POST["typ"][0] == "poezie")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, typ, figury_a_tropy, rymy, rytmus, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id, kompozice) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $_POST["typ"][0] . "', '" . $figuryATropy . "', '" . $rymy . "', '" . $rytmus . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "', '" . $kompozice . "');";
    }
    if ($_POST["typ"][0] == "drama")
    {
        $insertIntoDilo = "INSERT INTO dilo(nazev, literarni_druh, casoprostor, struktura, obsah, forma, typ, tema, vysvetleni_nazvu, jazykove_prostredky, autor_id, kompozice) VALUES('" . $nazevDila . "', '" . $literarniDruh . "', '" . $casoprostor . "', '" . $strukturaDila . "', '" . $obsahDila . "', '" . $forma . "', '" . $_POST["typ"][0] . "', '" . $temaDila . "', '" . $vysvetlenyNazevDila . "', '" . $jazykoveProstredky . "', '" . $autor . "', '" . $kompozice . "');";
    }
    mysqli_query($con, $insertIntoDilo);
    $getDiloID = "SELECT id FROM dilo WHERE nazev='" . $nazevDila . "';";
    $diloID = mysqli_fetch_row(mysqli_query($con, $getDiloID))[0];

    for ($i = 0; $i < count($literarniZanry); $i++)
    {
        $insertIntoDiloZanr = "INSERT INTO dilo_zanr(dilo_id, zanr_id) VALUES('" . $diloID . "', '" . test_input($literarniZanry[$i]) . "');";
        mysqli_query($con, $insertIntoDiloZanr);
    }

    if ($_POST["typ"][0] == "proza")
    {
        for ($i = 0; $i < count($postavy["jmenoPostavy"]); $i++)
        {
            $insertIntoPostava = "INSERT INTO postava(dilo_id, jmeno, typ_postavy, vlastnosti, literarni_typ) VALUES ('" . $getDiloID . "', '" . test_input($postavy["jmenoPostavy"][$i]) . "', '" . $postavy["typPostavy"][$i] . "', '" . $postavy["vlastnosti"][$i] . "', '" . $postavy["literarniTyp"][$i] . "');";
        }
    }
    if ($_POST["typ"][0] == "drama")
    {
        for ($i = 0; $i < count($postavyD["jmenoPostavyD"]); $i++)
        {
            $insertIntoPostava = "INSERT INTO postava(dilo_id, jmeno, typ_postavy, vlastnosti, literarni_typ, charakteristika) VALUES ('" . $getDiloID . "', '" . test_input($postavyD["jmenoPostavyD"][$i]) . "', '" . $postavyD["typPostavyD"][$i] . "', '" . $postavyD["vlastnostiD"][$i] . "', '" . $postavyD["literarniTypD"][$i] . "', '" . $postavyD["charakteristikaD"][$i] . "');";
        }
    }
}

header("Location: /seznam-knih/views/formDilo.php");