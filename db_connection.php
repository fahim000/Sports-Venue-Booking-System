<?php
// Replace these variables with your actual database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sport";

// Create a connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Optional: Set character set (if needed)
$connection->set_charset("utf8");
?>
