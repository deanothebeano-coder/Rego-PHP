<?php

    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    $connection = new mysqli($server_name, $username, $password, $database);

    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

?>

