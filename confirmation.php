<!-- confirmation.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Booking Confirmation</h1>
    <p>Your booking has been confirmed. Here are the details:</p>

    <?php
    // Retrieve the booking details from the database and display them here
    // You should have already saved the booking details in the "bookings" table in the database

    // For demonstration purposes, let's assume you have a function to fetch the booking details from the database
    // Replace the function name and database connection details with your actual implementation

    // Function to fetch booking details from the database
    function getBookingDetailsFromDatabase()
    {
        require_once "db_connection.php"; // Include the database connection file

        $bookingDetails = array();

        // Execute a query to fetch booking details from the "bookings" table
        $stmt = $connection->prepare("SELECT venue, player_name, player_email FROM bookings");
        $stmt->execute();
        $stmt->bind_result($venue, $playerName, $playerEmail);

        // Fetch and store each row of booking details
        while ($stmt->fetch()) {
            $bookingDetails[] = array("venue" => $venue, "playerName" => $playerName, "playerEmail" => $playerEmail);
        }

        $stmt->close();
        $connection->close();

        return $bookingDetails;
    }

    // Get the booking details from the database
    $bookingDetails = getBookingDetailsFromDatabase();

    // Display the booking details
    if (!empty($bookingDetails)) {
        echo "<ul>";
        foreach ($bookingDetails as $booking) {
            echo "<li>Venue: " . $booking["venue"] . ", Player Name: " . $booking["playerName"] . ", Player Email: " . $booking["playerEmail"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No booking details found.</p>";
    }
    ?>

    <p><a href="homepage.php">Back to Homepage</a></p>
</body>
</html>
