<?php
// used to connect to the database
$host = "localhost";
$db_name = "jiawei";
$username = "jiawei";
$password = "yz_[[4JM38Vp8gV/";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

    //echo "Connected successfully"; 
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}