<?php
session_start();
include 'funkce.php';

isLoggedElseRedirect();
html_start("Settings", "css/style");
nav();
banner("Settings");

footer();
html_end();