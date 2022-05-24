<?php
session_start();
include 'funkce.php';

echo 'You have been banned.. ';

session_unset();
session_destroy();