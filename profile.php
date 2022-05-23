<?php
session_start();
include 'funkce.php';

html_start($_SESSION["USERNAME"], "css/style");
nav();

banner($_SESSION["USERNAME"]);
?>
<p>lol</p>
<?php

footer();
html_end();