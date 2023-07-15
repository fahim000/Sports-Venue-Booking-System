<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];

    // Perform database operations (Replace with your own database connection code)
    $connection = mysqli_connect('localhost', 'username', 'password', 'database_name');

    // Check if the connection was successful
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Sanitize the user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $gender = mysqli_real_escape_string($connection, $gender);
    $age = mysqli_real_escape_string($connection, $age);

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO users (username, password, email, gender, age) VALUES ('$username', '$hashedPassword', '$email', '$gender', '$age')";
    $result = mysqli_query($connection, $query);

    // Check if the query executed successfully
    if ($result) {
        // Redirect the user to a success page or login page
        header("Location: login.php");
        exit;
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
    <title>Signup</title>
</head>
<body>
    <h1>Signup</h1>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <input type="submit" value="Signup">
    </form>
</body>
</html>
