<?php
session_start();

// Check if the user is logged in, redirect to login.php if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the user's booked venues from the database
// Replace this code with your database query

$bookedVenues = [
    ['name' => 'Venue 1', 'date' => '2023-07-15', 'time' => '10:00 AM'],
    ['name' => 'Venue 2', 'date' => '2023-07-16', 'time' => '02:00 PM'],
    // Additional booked venues
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booked Venues</title>
</head>
<body>
    <h1>Booked Venues</h1>
    <table>
        <tr>
            <th>Venue Name</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php foreach ($bookedVenues as $venue): ?>
        <tr>
            <td><?php echo $venue['name']; ?></td>
            <td><?php echo $venue['date']; ?></td>
            <td><?php echo $venue['time']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p><a href="profile.php">Go Back</a></p>
</body>
</html>
