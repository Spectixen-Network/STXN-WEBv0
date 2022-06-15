<?php

session_start();
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';
$con = db_connection_knihy();

if (isset($_GET["id"]))
{
    $id = $_GET["id"];

    if ($id == "all")
    {
        $result = vsechnaDila();

        for ($i = 0; $i < mysqli_num_rows($result); $i++)
        {
            $dilo = mysqli_fetch_array($result);
            $id = $dilo[0];
            $nazev = $dilo["nazev"];
            $kompozice = $dilo["kompozice"];
            $literarniDruh = $dilo["literarni_druh"]; //Lyrika, Epika, Drama
            $literarniZanr = mysqli_fetch_all(diloNazevZanru($id), MYSQLI_BOTH);
            $casoprostor = $dilo["casoprostor"];
            $struktura = $dilo["struktura"];
            $dej = $dilo["obsah"];
            $forma = $dilo["forma"];
            if ($dilo["typ"] == "poezie")
            {
                $figuryATropy = $dilo["figury_a_tropy"];
                $rymy = $dilo["rymy"];
                $rytmus = $dilo["rytmus"];
            }
            $tema = $dilo["tema"];
            $vysvetlenyNazevDila = $dilo["vysvetleni_nazvu"];
            $jazykProstredky = $dilo["jazykove_prostredky"];
            $autor = mysqli_fetch_all(autorInfo($dilo["autor_id"]), MYSQLI_BOTH);

            if ($dilo["typ"] == "proza")
            {
                knihaProza($id, $nazev, $autor, $literarniZanr, $literarniDruh, $forma, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej);
            }
            if ($dilo["typ"] == "poezie")
            {
                knihaPoezie($id, $nazev, $autor, $literarniZanr, $literarniDruh, $forma, $figuryATropy, $rymy, $rytmus, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej);
            }
            if ($dilo["typ"] == "drama")
            {
                knihaDrama($id, $nazev, $autor, $literarniZanr, $literarniDruh, $forma, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej);
            }
        }
    }
    else
    {
        $query = "SELECT * FROM dilo d INNER JOIN autor a ON d.autor_id = a.id WHERE d.id = " . $id;
    }
}

function knihaProza($id, $nazev, $autor, $literarniZanr, $LiterarniDruh, $forma, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej)
{
    $literarniZanry = "";
    for ($i = 0; $i < count($literarniZanr); $i++)
    {
        $literarniZanry .= $literarniZanr[$i]["nazev"] . ", ";
    }
    $autorSmer = mysqli_fetch_all(autorSmery($autor[0]["id"]), MYSQLI_BOTH);
    $autorSmery = "";
    for ($i = 0; $i < count($autorSmer); $i++)
    {
        $autorSmery .= $autorSmer[$i]["nazev"] . ", ";
    }
    $autorDila = mysqli_fetch_all(autorDilo($autor[0]["id"]), MYSQLI_BOTH);
    $autori = mysqli_fetch_all(otherAutorsOfSameSmer($autor[0]["id"]), MYSQLI_BOTH);
    $postavy = mysqli_fetch_all(diloPostavy($id), MYSQLI_BOTH);

    echo
    '
    <div style="text-align: center; font-size: 1.5em;">
        <div>
            <p><strong>Název:</strong> ' . $nazev . '</p>
            <p><strong>Literární druh:</strong> ' . $LiterarniDruh . '</p>
            <p><strong>Literární žánr:</strong> ' . $literarniZanry . '</p>
            <p><strong>Časoprostor:</strong> ' . $casoprostor . '</p>
            <p><strong>Struktůra díla:</strong> ' . $struktura . '</p>
            <p><strong>Kompozice:</strong> ' . $kompozice . '</p>
            <p><strong>Obsah díla:</strong> ' . $dej . '</p>
            <p><strong>Forma:</strong> ' . $forma .
        '</p>
            <p><strong>Postavy:</strong></p>';
    for ($i = 0; $i < count($postavy); $i++)
    {
        echo "<p>{$postavy['jmeno']} | {$postavy['typ_postavy']} | {$postavy['vlastnost']} | {$postavy['literarni_typ']}</p>";
    }
    echo '        <p><strong>Struktůra</strong> ' . $struktura . '</p>
            <p><strong>Téma díla:</strong> ' . $tema . '</p>
            <p><strong>Vysvětlení názvu a jeho typ</strong> ' . "" . '</p>
            <p><strong>Jazykové prostředky</strong> ' . $jazykProstredky .
        '</p>
            <h2>Autoři</h2>
            <p><strong>Jméno Příjmení:</strong> ' . $autor["jmeno"] . " " . $autor["prijmeni"] . '</p>
            <p><strong>Literární Směr:</strong> ' . $autorSmery . '</p>
            <p><strong>Skupina:</strong> ' . $autor["skupina"] . '</p>';
    for ($i = 0; $i < count($autorDila); $i++)
    {
        if ($autorDila[$i]["id"] == $id) continue;
        echo  '<p><strong>Další díla - žánr:</strong> ' . $autorDila[$i]["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDila[$i]["id"]))[0] . '</p>';
    }
    echo '
            <h2>Další autoři tohoto směru</h2>';
    for ($i = 0; $i < count($autori), $i < 4; $i++)
    {
        $autorDilo = mysqli_fetch_assoc(autorDilo($autori[$i]["id"]));
        if ($autori[$i]["id"] == $autor[0]["id"]) continue;
        echo '<p><strong>Jméno Příjmení:</strong> ' . $autori[$i]["jmeno"] . " " . $autori[$i]["prijmeni"] . '</p>';
        if (mysqli_num_rows(autorDilo($autori[$i]["id"])) == 0) break;
        echo '<p><strong>Dílo - žánr:</strong> ' . $autorDilo["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDilo["id"]))[0] . '</p>';
    }
    echo '    </div>
    <br>
    <br>
    <br>
    <br>
    </div>
    ';
}
function knihaPoezie($id, $nazev, $autor, $literarniZanr, $LiterarniDruh, $forma, $figuryATropy, $rymy, $rytmus, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej)
{
    $literarniZanry = "";
    for ($i = 0; $i < count($literarniZanr); $i++)
    {
        $literarniZanry .= $literarniZanr[$i]["nazev"] . ", ";
    }
    $autorSmer = mysqli_fetch_all(autorSmery($autor[0]["id"]), MYSQLI_BOTH);
    $autorSmery = "";
    for ($i = 0; $i < count($autorSmer); $i++)
    {
        $autorSmery .= $autorSmer[$i]["nazev"] . ", ";
    }
    $autorDila = mysqli_fetch_all(autorDilo($autor[0]["id"]), MYSQLI_BOTH);
    $autori = mysqli_fetch_all(otherAutorsOfSameSmer($autor[0]["id"]), MYSQLI_BOTH);
    echo
    '
    <div style="text-align: center; font-size: 1.5em;">
        <h1>Dílo</h1>
        <div>
            <p><strong>Název:</strong> ' . $nazev . '</p>
            <p><strong>Literární druh:</strong> ' . $LiterarniDruh . '</p>
            <p><strong>Literární žánr:</strong> ' . $literarniZanry . '</p>
            <p><strong>Časoprostor:</strong> ' . $casoprostor . '</p>
            <p><strong>Struktůra díla:</strong> ' . $struktura . '</p>
            <p><strong>Kompozice:</strong> ' . $kompozice . '</p>
            <p><strong>Obsah díla:</strong> ' . $dej . '</p>
            <p><strong>Forma:</strong> ' . $forma . '</p> 
            <p><strong>Figury a Tropy:</strong> ' . $figuryATropy . '</p>
            <p><strong>Rýmy:</strong> ' . $rymy . '</p>
            <p><strong>Rytmus:</strong> ' . $rytmus . '</p>
            <p><strong>Struktůra</strong> ' . $struktura . '</p>
            <p><strong>Téma díla:</strong> ' . $tema . '</p>
            <p><strong>Vysvětlení názvu a jeho typ</strong> ' . "" . '</p>
            <p><strong>Jazykové prostředky</strong> ' . $jazykProstredky . '</p>
            <h2>Autoři</h2>
            <p><strong>Jméno Příjmení:</strong> ' . $autor[0]["jmeno"] . " " . $autor[0]["prijmeni"] . '</p>
            <p><strong>Literární Směr:</strong> ' . $autorSmery . '</p>
            <p><strong>Skupina:</strong> ' . $autor[0]["skupina"] . '</p>';
    for ($i = 0; $i < count($autorDila); $i++)
    {
        if ($autorDila[$i]["id"] == $id) continue;
        echo  '<p><strong>Další díla - žánr:</strong> ' . $autorDila[$i]["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDila[$i]["id"]))[0] . '</p>';
    }
    echo '
            <h2>Další autoři tohoto směru</h2>';
    for ($i = 0; $i < count($autori); $i++)
    {
        $autorDilo = mysqli_fetch_assoc(autorDilo($autori[$i]["id"]));
        if ($autori[$i]["id"] == $autor[0]["id"]) continue;
        echo '<p><strong>Jméno Příjmení:</strong> ' . $autori[$i]["jmeno"] . " " . $autori[$i]["prijmeni"] . '</p>';
        if (mysqli_num_rows(autorDilo($autori[$i]["id"])) == 0) break;
        echo '<p><strong>Dílo - žánr:</strong> ' . $autorDilo["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDilo["id"]))[0] . '</p>';
    }
    echo '    </div>
    <br>
    <br>
    <br>
    <br>
    </div>
    ';
}
function knihaDrama($id, $nazev, $autor, $literarniZanr, $LiterarniDruh, $forma, $kompozice, $struktura, $casoprostor, $tema, $jazykProstredky, $dej)
{
    $literarniZanry = "";
    for ($i = 0; $i < count($literarniZanr); $i++)
    {
        $literarniZanry .= $literarniZanr[$i]["nazev"] . ", ";
    }
    $autorSmer = mysqli_fetch_all(autorSmery($autor[0]["id"]), MYSQLI_BOTH);
    $autorSmery = "";
    for ($i = 0; $i < count($autorSmer); $i++)
    {
        $autorSmery .= $autorSmer[$i]["nazev"] . ", ";
    }
    $autorDila = mysqli_fetch_all(autorDilo($autor[0]["id"]), MYSQLI_BOTH);
    $autori = mysqli_fetch_all(otherAutorsOfSameSmer($autor[0]["id"]), MYSQLI_BOTH);
    $postavy = mysqli_fetch_all(diloPostavy($id), MYSQLI_BOTH);
    echo
    '
    <div style="text-align: center; font-size: 1.5em;">
        <div>
            <p><strong>Název:</strong> ' . $nazev . '</p>
            <p><strong>Literární druh:</strong> ' . $LiterarniDruh . '</p>
            <p><strong>Literární žánr:</strong> ' . $literarniZanry . '</p>
            <p><strong>Časoprostor:</strong> ' . $casoprostor . '</p>
            <p><strong>Struktůra díla:</strong> ' . $struktura . '</p>
            <p><strong>Kompozice:</strong> ' . $kompozice . '</p>
            <p><strong>Obsah díla:</strong> ' . $dej . '</p>
            <p><strong>Forma:</strong> ' . $forma . '</p>
            <p><strong>Postavy:</strong></p>';
    for ($i = 0; $i < count($postavy); $i++)
    {
        echo "<p>{$postavy['jmeno']} | {$postavy['typ_postavy']} | {$postavy['vlastnost']} | {$postavy['literarni_typ']} | {$postavy['charakteristika']}</p>";
    }
    echo '  <p><strong>Struktůra</strong> ' . $struktura . '</p>
            <p><strong>Téma díla:</strong> ' . $tema . '</p>
            <p><strong>Vysvětlení názvu a jeho typ</strong> ' . "" . '</p>
            <p><strong>Jazykové prostředky</strong> ' . $jazykProstredky .
        '</p>
            <h2>Autoři</h2>
            <p><strong>Jméno Příjmení:</strong> ' . $autor[0]["jmeno"] . " " . $autor[0]["prijmeni"] . '</p>
            <p><strong>Literární Směr:</strong> ' . $autorSmery . '</p>
            <p><strong>Skupina:</strong> ' . $autor[0]["skupina"] . '</p>';
    for ($i = 0; $i < count($autorDila); $i++)
    {
        if ($autorDila[$i]["id"] == $id) continue;
        echo  '<p><strong>Další díla - žánr:</strong> ' . $autorDila[$i]["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDila[$i]["id"]))[0] . '</p>';
    }
    echo '
            <h2>Další autoři tohoto směru</h2>';
    for ($i = 0; $i < count($autori), $i < 4; $i++)
    {
        $autorDilo = mysqli_fetch_assoc(autorDilo($autori[$i]["id"]));
        if ($autori[$i]["id"] == $autor[0]["id"]) continue;
        echo '<p><strong>Jméno Příjmení:</strong> ' . $autori[$i]["jmeno"] . " " . $autori[$i]["prijmeni"] . '</p>';
        if (mysqli_num_rows(autorDilo($autori[$i]["id"])) == 0) break;
        echo '<p><strong>Dílo - žánr:</strong> ' . $autorDilo["nazev"] . " - " . mysqli_fetch_row(diloNazevZanru($autorDilo["id"]))[0] . '</p>';
    }
    echo '    </div>
    <br>
    <br>
    <br>
    <br>
    </div>
    ';
}
function knih($nazev, $originalniJazyk, $autor, $ostatniDila, $literarniZanr, $LiterarniSmer, $LiterarniDruh, $forma, $kompozice, $struktura, $casoprostor, $hlavniPostavy, $vedlejsiPostavy, $tema, $hlavniMyslenka, $jazykProstredky, $kontext, $dej)
{
    echo
    '
        <div>
            <h3>Název:</h3>
            <p>' . $nazev . '</p>
            <h3>Originální jazyk:</h3>
            <p>' . $originalniJazyk . '</p>
            <h3>Autor:</h3>
            <p>' . $autor . '</p>
            <h3>Další díla:</h3>
            <p>' . $ostatniDila . '</p>
            <h3>Literární žánr:</h3>
            <p>' . $literarniZanr . '</p>
            <h3>Literární směr:</h3>
            <p>' . $LiterarniSmer . '</p>
            <h3>Literární druh:</h3>
            <p>' . $LiterarniDruh . '</p>
            <h3>Forma:</h3>
            <p>' . $forma . '</p>
            <h3>Kompozice:</h3>
            <p>' . $kompozice . '</p>
            <h3>Struktura:</h3>
            <p>' . $struktura . '</p>
            <h3>Časoprostor:</h3>
            <p>' . $casoprostor . '</p>
            <h3>Hlavní postavy:</h3>
            <p>' . $hlavniPostavy . '</p>
            <h3>Vedlejší postavy:</h3>
            <p>' . $vedlejsiPostavy . '</p>
            <h3>Téma:</h3>
            <p>' . $tema . '</p>
            <h3>Hlavní myšlenka:</h3>
            <p>' . $hlavniMyslenka . '</p>
            <h3>Jazykové a literární prostředky:</h3>
            <p>' . $jazykProstredky . '</p>
            <h3>Kontext:</h3>
            <p>' . $kontext . '</p>
            <h3>Děj:</h3>
            <p>' . $dej . '</p>
        </div>
    ';
}
function otherAutorsOfSameSmerQuery($autorID)
{
    return "SELECT * FROM autor a INNER JOIN autor_smer a_s ON a.id = a_s.autor_id WHERE a_s.smer_id = ANY (SELECT a_s.smer_id FROM autor a INNER JOIN autor_smer a_s ON a.id = a_s.autor_id WHERE a.id = " . $autorID . ");";
}
function otherAutorsOfSameSmer($autorID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, otherAutorsOfSameSmerQuery($autorID));
}
function autorDiloQuery($autorID)
{
    return "SELECT * FROM dilo WHERE autor_id = " . $autorID . ";";
}
function autorDilo($autorID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, autorDiloQuery($autorID));
}
function diloNazevZanruQuery($diloID)
{
    return "SELECT z.nazev FROM dilo d INNER JOIN dilo_zanr dz ON d.id = dz.dilo_id INNER JOIN zanr z ON dz.zanr_id = z.id WHERE d.id = " . $diloID . ";";
}
function diloNazevZanru($diloID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, diloNazevZanruQuery($diloID));
}
function vsechnaDilaQuery()
{
    return "SELECT * FROM dilo d INNER JOIN autor a ON d.autor_id = a.id";
}
function vsechnaDila()
{
    $con = db_connection_knihy();
    return mysqli_query($con, vsechnaDilaQuery());
}
function specificDiloQuery($diloID)
{
    return "SELECT * FROM dilo d INNER JOIN autor a ON d.autor_id = a.id WHERE d.id = " . $diloID . "";
}
function specificDilo($diloID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, specificDiloQuery($diloID));
}
function diloPostavyQuery($diloID)
{
    return "SELECT * FROM postava WHERE dilo_id =" . $diloID;
}
function diloPostavy($diloID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, diloPostavyQuery($diloID));
}
function autorInfoQuery($autorID)
{
    return "SELECT a.*, a_s.smer_id, s.nazev FROM autor a INNER JOIN autor_smer a_s ON a_s.autor_id = a.id INNER JOIN smer s ON a_s.smer_id = s.id WHERE a.id=" . $autorID . ";";
}
function autorInfo($autorID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, autorInfoQuery($autorID));
}
function autorSmeryQuery($autorID)
{
    return "SELECT s.* FROM autor a INNER JOIN autor_smer a_s ON a_s.autor_id = a.id INNER JOIN smer s ON a_s.smer_id = s.id WHERE a.id=" . $autorID . ";";
}
function autorSmery($autorID)
{
    $con = db_connection_knihy();
    return mysqli_query($con, autorSmeryQuery($autorID));
}