<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'realstatedb';
    $conn = new mysqli($host, $username, $password, $dbName);
    if ($conn->connect_error){
        die ($conn->connect_error);
    }
?>