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

<div class="container d-flex justify-content-center">

    <form action="../saves/saveDilo.php" method="POST">
        <div class="input-group mb-1">
            <span class="input-group-text">Název Díla</span>
            <input type="text" name="nazev" class="form-control">
        </div>
        <div class="input-group mb-1">
            <label class="input-group-text" for="inputGroupSelect01">Literární Druh</label>
            <select name="literarniDruh" class="form-select" id="inputGroupSelect01" style="overflow: auto;" required>
                <option value="Lyrika">Lyrika</option>
                <option value="Epika">Epika</option>
                <option value="Drama">Drama</option>
            </select>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Kompozice</span>
            <input type="text" name="kompozice" class="form-control">
        </div>
        <div class="input-group mb-1">
            <label class="input-group-text" for="inputGroupSelect02">Literární Žánr</label>
            <select name="literarniZanry[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;" multiple required>
                <?php
                for ($i = 0; $i < count($zanry); $i++)
                {
                    option($zanry[$i][0], $zanry[$i][1]);
                }
                ?>
            </select>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Časoprostor</span>
            <input type="text" name="casoprostor" class="form-control">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Struktůra díla</span>
            <input type="text" name="strukturaDila" class="form-control">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Obsah díla</span>
            <input type="text" name="obsahDila" class="form-control">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Forma</span>
            <input type="text" name="forma" class="form-control">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="typ[]" id="proza" value="proza" onclick="prozaF();">
            <label class="form-check-label" for="proza">
                Próza
            </label>
            <div id="proza-input" class="showNone">
                <button type="button" class="btn btn-primary mb-1" onclick="pridatPostavu();">Přidat postavu</button><br>
                <div id="postava">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Postava, Vlastnosti</span>
                        <input type="text" name="jmenoPostavy[]" class="form-control">
                        <select name="typPostavy[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value="Hlavní">Hlavní</option>
                            <option value="Vedlejší">Vedlejší</option>
                        </select>
                        <select name="vlastnosti[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value="Kladná">Kladná</option>
                            <option value="Záporná">Záporná</option>
                        </select>
                        <select name="literarniTyp[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value=""></option>
                            <option value="Literární">Literární</option>
                            <option value="Historická">Historická</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="typ[]" id="poezie" value="poezie" onclick="poezieF();">
            <label class="form-check-label" for="poezie">
                Poezie
            </label>
            <div id="poezie-input" class="showNone">
                <div class="input-group mb-1">
                    <span class="input-group-text">Figury a Tropy</span>
                    <input type="text" name="figuryTropy" class="form-control">
                </div>
                <div class="input-group mb-1">
                    <span class="input-group-text">Rýmy</span>
                    <input type="text" name="rymy" class="form-control">
                </div>
                <div class="input-group mb-1">
                    <span class="input-group-text">Rytmus</span>
                    <input type="text" name="rytmus" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="typ[]" id="drama" value="drama" onclick="dramaF();">
            <label class="form-check-label" for="drama">
                Drama
            </label>
            <div id="drama-input" class="showNone">
                <button type="button" class="btn btn-primary mb-1" onclick="pridatPostavuD();">Přidat postavu</button><br>
                <div class="input-group mb-1">
                    <span class="input-group-text">Charakteristika</span>
                    <input type="text" name="charakteristika" class="form-control">
                </div>
                <div id="postavaD">
                    <div class="input-group mb-1">
                        <span class="input-group-text">Postava, Vlastnosti</span>
                        <input type="text" name="jmenoPostavy[]" class="form-control">
                        <select name="typPostavy[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value="Hlavní">Hlavní</option>
                            <option value="Vedlejší">Vedlejší</option>
                        </select>
                        <select name="vlastnosti[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value="Kladná">Kladná</option>
                            <option value="Záporná">Záporná</option>
                        </select>
                        <select name="literarniTyp[]" class="form-select" id="inputGroupSelect02" style="overflow: auto;">
                            <option value=""></option>
                            <option value="Literární">Literární</option>
                            <option value="Historická">Historická</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Téma díla</span>
            <input type="text" name="temaDila" class="form-control">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Vysvětlt název díla a uvést jeho typ</span>
            <input type="text" name="nazevDilaVysvetli" class="form-control">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text">Jazykové prostředky</span>
            <input type="text" name="jazykoveProstredky" class="form-control">
        </div>

        <h2>Autor</h2>
        <div class="input-group mb-1">
            <label class="input-group-text" for="inputGroupSelect03">Autor</label>
            <select name="autor" class="form-select" id="inputGroupSelect03">
                <?php
                for ($i = 0; $i < count($autor); $i++)
                {
                    option($autor[$i][0], $autor[$i][1] . " " . $autor[$i][2] . " | " . $autor[$i][3]);
                }
                ?>
            </select>
        </div>
        <div class="input-group d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">Uložit</button>
        </div>
    </form>
    <script>
    function pridatPostavu() {
        let proza = document.getElementById("proza-input");
        let input = document.getElementById("postava");
        proza.appendChild(input.cloneNode(true));
    }

    function pridatPostavuD() {
        let proza = document.getElementById("drama-input");
        let input = document.getElementById("postavaD");
        proza.appendChild(input.cloneNode(true));
    }
    </script>
</div>


<?php
footer();
html_end();

function option($id, $name)
{
    echo '<option value="' . $id . '">' . $name . '</option>';
}