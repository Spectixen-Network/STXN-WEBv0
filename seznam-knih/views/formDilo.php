<?php
session_start();
include_once '../else/database.php';
include_once '../../functions/globalFunctions.php';
$con = db_connection_knihy();

$query = "SELECT * FROM zanr";
$result = mysqli_query($con, $query);
$zanry = mysqli_fetch_all($result);

$autorIDQuery = "SELECT * FROM autor;";
$autor = mysqli_fetch_all(mysqli_query($con, $autorIDQuery));

html_start("Seznam Knih | Dílo", "../../css/style");
nav();
banner("Seznam Knih | Dilo");
?>
<script src="js/inputs.js" type="text/javascript"></script>
<h1>Dílo</h1>
<form action="../saves/saveDilo.php" method="POST">
    <input type="text" name="nazev" placeholder="Název Díla"><br>
    <input type="text" name="literarniDruh" placeholder="Literární Druh"><br>
    <select name="literarniZanry[]" multiple>
        <option disabled>---Vyber Linerární Žánr---</option>
        <?php
        for ($i = 0; $i < count($zanry); $i++)
        {
            option($zanry[$i][0], $zanry[$i][1]);
        }
        ?>
    </select><br>
    <input type="text" name="casoprostor" placeholder="Časoprostor"><br>
    <input type="text" name="strukturaDila" placeholder="Struktůra díla"><br>
    <input type="text" name="obsahDila" placeholder="Obsah díla"><br>
    <input type="text" name="forma" placeholder="Forma"><br>
    <label for="typ">Próza</label>
    <input type="radio" name="typ[]" id="proza" value="proza" onclick="prozaF();"><br>
    <div id="proza-input" class="showNone">
        <input type="text" name="postavyJmena" id="" placeholder="Postavy - Jména"><br>
        <input type="text" name="typy" id="" placeholder="Typy"><br>
    </div>
    <label for="typ">Poezie</label>
    <input type="radio" name="typ[]" id="poezie" value="poezie" onclick="poezieF()"><br>
    <div id="poezie-input" class="showNone">
        <input type="text" name="figuryTropy" id="" placeholder="Figury a Tropy"><br>
        <input type="text" name="rymy" id="" placeholder="Rýmy"><br>
        <input type="text" name="rytmus" id="" placeholder="Rytmus"><br>
    </div>
    <label for="typ">Drama</label>
    <input type="radio" name="typ[]" id="drama" value="drama" onclick="dramaF();"><br>
    <div id="drama-input" class="showNone">
        <input type="text" name="postavyDruhy" placeholder="Postavy - Druhy"><br>
        <input type="text" name="charakteristika" placeholder="Charakteristika"><br>
    </div>
    <input type="text" name="temaDila" placeholder="Téma díla"><br>
    <input type="text" name="nazevDilaVysvetli" placeholder="Vysvětlt název díla a uvést jeho typ"><br>
    <input type="text" name="jazykoveProstredky" placeholder="Jazykové prostředky"><br>
    <h2>Autor</h2>
    <select name="autor" id="">
        <?php
        for ($i = 0; $i < count($autor); $i++)
        {
            option($autor[$i][0], $autor[$i][1] . " " . $autor[$i][2] . " | " . $autor[$i][3]);
        }
        ?>
    </select>
    <input type="submit" value="Odeslat">
</form>


<?php
footer();
html_end();

function option($id, $name)
{
    echo '<option value="' . $id . '">' . $name . '</option>';
}