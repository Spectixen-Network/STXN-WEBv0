<?php
session_start();
include_once '../../functions/globalFunctions.php';

html_start("Seznam knih | Přidání žánru", "../../css/style");
nav();
banner("Seznam knih | Pridani zanru");
?>

<h1>Přidání žánru</h1>
<form action="../saves/saveZanr.php" method="POST">
    <input type="text" name="nazev" id="" placeholder="Název žánru">
    <input type="submit" value="Odeslat">
</form>

<?php
footer();
html_end();