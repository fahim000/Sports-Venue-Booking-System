<?php
// ... (Existing PHP code)

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $venue = $_POST["venue"];

    // Process the players' information (11 players in this example)
    $players = array();
    for ($i = 1; $i <= 11; $i++) {
        $name = $_POST["player_name_" . $i];
        $email = $_POST["player_email_" . $i];
        $players[] = array("name" => $name, "email" => $email);
    }

    // Save the booking details to the "bookings" table in the database
    require_once "db_connection.php"; // Include the database connection file

    // Prepare and execute the INSERT query for each player
    $stmt = $connection->prepare("INSERT INTO bookings (venue, player_name, player_email) VALUES (?, ?, ?)");
    foreach ($players as $player) {
        $stmt->bind_param("sss", $venue, $player["name"], $player["email"]);
        $stmt->execute();
    }

    // Close the statement and database connection
    $stmt->close();
    $connection->close();

    // Redirect the user to a confirmation page or any other appropriate page
    header("Location: confirmation.php");
    exit();
} else {
    // Redirect the user back to the booking form if accessed directly without form submission
    header("Location: booking_form.php");
    exit();
}
?>
