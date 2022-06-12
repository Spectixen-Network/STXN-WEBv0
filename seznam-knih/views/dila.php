<?php
session_start();
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';
// , jmena_postav, typy
$con = db_connection_knihy();

if (isset($_GET["id"]))
{
    $id = $_GET["id"];

    if ($id == "all")
    {
        $query = "SELECT * FROM dilo d INNER JOIN autor a ON d.autor_id = a.id";
        $result = mysqli_query($con, $query);

        for ($i = 0; $i < mysqli_num_rows($result); $i++)
        {
            $dilo = mysqli_fetch_array($result);
            $nazevDila = $dilo["nazev"];
            $literarniDruh = $dilo["literarni_druh"];
            $literarniZanry = $dilo[""];
            $casoprostor = $dilo["casoprostor"];
            $strukturaDila = $dilo["struktura"];
            $obsahDila = $dilo["obsah"];
            $forma = $dilo["forma"];
            if ($_POST["typ"][0] == "proza")
            {
                $jmenaPostav = $dilo[""];
                $typy = $dilo[""];
            }
            if ($_POST["typ"][0] == "poezie")
            {
                $figuryATropy = $_POST["figuryTropy"];
                $rymy = $dilo[""];
                $rytmus = $dilo[""];
            }
            if ($_POST["typ"][0] == "drama")
            {
                $druhyPostav = $dilo[""];
                $charakteristika = $dilo[""];
            }
            $temaDila = $dilo["tema"];
            $vysvetlenyNazevDila = $dilo["vysvetleni_nazvu"];
            $jazykoveProstredky = $dilo["jazykove_prostredky"];
            $autor = $dilo["jmeno"] . " " . $dilo["prijmeni"];

            kniha($nazevDila, "CZ", $autor, "test", $literarniZanry, $literarniDruh, $literarniDruh, $forma, "test", $strukturaDila, $casoprostor, $jmenaPostav, $druhyPostav, $temaDila, "Drogy", $jazykoveProstredky, "kontext", $obsahDila);
        }
    }
    else
    {
        $query = "SELECT * FROM dilo d INNER JOIN autor a ON d.autor_id = a.id WHERE d.id = " . $id;
    }
}

function kniha($nazev, $originalniJazyk, $autor, $ostatniDila, $literarniZanr, $LiterarniSmer, $LiterarniDruh, $forma, $kompozice, $struktura, $casoprostor, $hlavniPostavy, $vedlejsiPostavy, $tema, $hlavniMyslenka, $jazykProstredky, $kontext, $dej)
{
    echo
    '
        <div>
        <h3>Název:</h3>
        <p>' . $nazev . '</p>
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