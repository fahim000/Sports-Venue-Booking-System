<?php
session_start();

// Check if the user is logged in, redirect to login.php if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Update the user's profile information in the database
// Replace this code with your database update query

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission and update the profile
    // ...

    // Redirect to the profile page after updating
    header("Location: profile.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="edit-profile.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <!-- Additional fields for editing profile -->
        
        <input type="submit" value="Update">
    </form>

    <p><a href="profile.php">Cancel</a></p>
</body>
</html>
