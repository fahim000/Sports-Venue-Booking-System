<?php
session_start();

// Check if the user is logged in, redirect to login.php if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Handle the venue booking process
// Replace this code with your booking logic

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the venue booking form
    // ...

    // Redirect to the booked venues page or a confirmation page
    header("Location: bookings.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Venue</title>
</head>
<body>
    <h1>Book Venue</h1>
    <form action="book-venue.php" method="POST">
        <!-- Venue booking form fields -->
        
        <input type="submit" value="Book">
    </form>

    <p><a href="profile.php">Cancel</a></p>
</body>
</html>
