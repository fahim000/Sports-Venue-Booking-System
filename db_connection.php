<?php
// Database configuration
$db_host = 'localhost';
$db_username = 'your_username';
$db_password = 'your_password';
$db_name = 'your_database_name';

// Create a database connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check the connection
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
?>
