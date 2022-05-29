<?php
session_start();
include_once 'functions/globalFunctions.php';

echo 'You have been banned.. ';

session_unset();
session_destroy();
