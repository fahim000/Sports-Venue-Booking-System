<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform database operations (Replace with your own database connection code)
    $connection = mysqli_connect('localhost', 'username', 'password', 'database_name');
    
    // Check if the connection was successful
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Sanitize the user input
    $username = mysqli_real_escape_string($connection, $username);

    // Retrieve the user's password hash from the database
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    // Check if the query executed successfully
    if ($result) {
        // Check if the user exists in the database
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set session variables and redirect to the profile page
                session_start();
                $_SESSION['username'] = $username;
                header("Location: profile.php");
                exit;
            } else {
                // Password is incorrect
                $errorMessage = "Invalid username or password";
            }
        } else {
            // User does not exist
            $errorMessage = "Invalid username or password";
        }
    } else {
        // Handle any errors during the database operation
        $errorMessage = mysqli_error($connection);
        // You can display or handle the error as per your project's requirements
    }

    // Close the database connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
