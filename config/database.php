<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'lance');
    define('DB_PASS', '12345');
    define('DB_NAME', 'chatterme');

    //Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn->connect_error){
        die('Connection Failed ' . $conn->connect_error);
    }
?>