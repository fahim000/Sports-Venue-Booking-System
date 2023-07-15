<?php
session_start();

// Check if the user is logged in, redirect to login.php if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the user's profile information from the database
// Replace this code with your database query

$profileInfo = [
    'username' => 'JohnDoe',
    'email' => 'john.doe@example.com',
    'age' => 25,
    // Additional profile fields
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Welcome, <?php echo $profileInfo['username']; ?></h1>
    <p>Email: <?php echo $profileInfo['email']; ?></p>
    <p>Age: <?php echo $profileInfo['age']; ?></p>

    <p><a href="edit-profile.php">Edit Profile</a></p>
    <p><a href="delete-account.php">Delete Account</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
