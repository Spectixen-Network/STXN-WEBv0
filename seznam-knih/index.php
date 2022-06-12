<?php
include_once '../functions/globalFunctions.php';
html_start("Seznam Knih", "../css/style");
nav();
banner("Seznam Knih | Menu");
?>

<a href="formAutor.php">Přidání autora</a><br>
<a href="formDilo.php">Přidání díla</a><br>
<a href="formSmer.html">Přidání směru</a><br>
<a href="formZanr.html">Přidání žánru</a><br>
<?php
footer();
html_end();