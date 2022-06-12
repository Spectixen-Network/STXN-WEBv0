<?php
session_start();
include_once '../../functions/globalFunctions.php';

html_start("Seznam Knih | Přidání směru", "../../css/style");
nav();
banner("Seznam Knih | Pridani smeru");
?>

<div class="container d-flex justify-content-center">
    <form action="../saves/saveSmer.php" method="POST">
        <div style="height: 44.5vh;">
            <div class="knihy-forms">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroup-sizing-default">Směr</span>
                    <input type="text" class="form-control" name="nazev">
                </div>
                <div class="input-group d-grid gap-2 col-6 mx-auto mt-1">
                    <button type="submit" class="btn btn-primary">Přidat</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
footer();
html_end();