<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

html_start("Settings", "css/style");
nav();

banner("Settings");

footer();
html_end();