<?php
session_start();
include 'funkce.php';

html_start("Files", "css/style");
nav();

banner("File Manager");

?>

<div class="container">
    <?php
    some_text();
    ?>
</div>
<?php
html_end();
