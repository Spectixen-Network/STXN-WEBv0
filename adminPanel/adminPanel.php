<?php
session_start();
include '../funkce.php';

html_start("Admin", "../css/style");
nav();
banner("Admin Panel");
some_text();

echo __DIR__ . "<br>";
echo __NAMESPACE__ . "<br>";
echo __FILE__ . "<br>";

html_end();