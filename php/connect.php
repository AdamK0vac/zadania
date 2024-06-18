<?php

$host = "localhost";
$username = "userdb";
$password = "databaza";
$dbname = "northwindmysql";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;