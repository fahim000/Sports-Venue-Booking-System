<!-- booking_form.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book a Venue</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Book a Venue</h1>
    <form method="post" action="process_booking.php">
        <label for="venue">Choose a Venue:</label>
        <select name="venue" id="venue">
            <option value="venue1">Bashundhara</option>
            <option value="venue2">Dhanmondi</option>
            <option value="venue3">Mirpur</option>
        </select>

        <h2>Players Information:</h2>
        <p>Enter the names and emails of the 11 players:</p>
        <table>
            <tr>
                <th>Player Name</th>
                <th>Player Email</th>
            </tr>
            <?php
            for ($i = 1; $i <= 11; $i++) {
                echo '
                <tr>
                    <td><input type="text" name="player_name_' . $i . '" placeholder="Player ' . $i . ' Name"></td>
                    <td><input type="email" name="player_email_' . $i . '" placeholder="Player ' . $i . ' Email"></td>
                </tr>
                ';
            }
            ?>
        </table>

        <input type="submit" value="Submit">
    </form>

    <p><a href="homepage.php">Back to Homepage</a></p>
</body>
</html>
