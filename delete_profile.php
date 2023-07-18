<?php
// Start the session (if not already started)
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once "db_connection.php";

// Get the username from the session
$username = $_SESSION["username"];

// Prepare and execute the query to delete the user from the database
$stmt = $connection->prepare("DELETE FROM sport WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    // Account deleted successfully, destroy the session and log the user out
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    echo "Error occurred while deleting your account. Please try again later.";
}

$stmt->close();
?>
