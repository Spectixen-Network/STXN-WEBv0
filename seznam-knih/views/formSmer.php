<?php
session_start();
include_once '../../functions/globalFunctions.php';

html_start("Seznam Knih | Přidání směru", "../../css/style");
nav();
banner("Seznam Knih | Pridani smeru");
?>
<h1>Přidání směru</h1>
<form action="../saves/saveSmer.php" method="POST">
    <input type="text" name="nazev" id="" placeholder="Název směru">
    <input type="submit" value="Odeslat">
</form>
<?php
footer();
html_end();