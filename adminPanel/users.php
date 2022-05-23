<?php
session_start();
include '../funkce.php';
include  'adminPanelFunctions.php';

html_start("Admin", "../css/style");
nav();

adminSidebar();

html_end();