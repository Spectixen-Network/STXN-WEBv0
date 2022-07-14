<?php
session_start();

include_once '../functions/globalFunctions.php';
include_once 'Car.php';


html_start("Car", "css/global");
nav();
banner("Car Road Trip");

$car = new Car();


footer();
html_end();