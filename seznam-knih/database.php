<?php
function db_connection_knihy()
{
    $db_info = json_decode(file_get_contents('else/database.json'), true);
    $connection = mysqli_init();
    $server = $db_info["db_ip"];
    $database = $db_info["db_name"];
    $db_username = $db_info["db_username"];
    $db_password = $db_info["db_password"];

    if (!mysqli_real_connect($connection, $server, $db_username, $db_password, $database))
    {
        die("Nepodařilo se připojit k databázi");
    }
    return $connection;
}