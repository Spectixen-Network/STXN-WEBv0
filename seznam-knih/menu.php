<?php
session_start();
include_once '../functions/globalFunctions.php';
html_start("Seznam Knih", "../css/style");
nav();
banner("Seznam Knih | Menu");

?>

<div class="container d-flex justify-content-center">
    <ul class="list-group knihy-menu" style="width: 50vh; text-align: center;">
        <li class="list-group-item"><a href="views/seznam.php">Seznam Knih</a></li>
        <li class="list-group-item"><a href="views/formAutor.php">Přidání autora</a></li>
        <li class="list-group-item"><a href="views/formDilo.php">Přidání díla</a></li>
        <li class="list-group-item"><a href="views/formSmer.php">Přidání směru</a></li>
        <li class="list-group-item"><a href="views/formZanr.php">Přidání žánru</a></li>
    </ul>
</div>

<?php
footer();
html_end();