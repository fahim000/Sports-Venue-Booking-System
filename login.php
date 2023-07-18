<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    

</head>
<body>
    <h1>Login</h1>
    <?php
    // Include the database connection file
    require_once "db_connection.php";

    // Initialize variables to hold user input
    $username = $password = "";

    // Validation and form submission handling
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve and sanitize form data
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        // Query the database to fetch the user's password
        $stmt = $connection->prepare("SELECT password FROM sport WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
    
        if ($stmt->fetch() && $password === $storedPassword) {
            // Passwords match, login successful
            session_start();
            $_SESSION["username"] = $username;
            header("Location: homepage.php");
            exit();
        } else {
            // Incorrect username or password, display an error message
            $errors[] = "Incorrect username or password.";
        }
    
        $stmt->close();
    }
    
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $username; ?>"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" value="Log In">
    </form>

    <?php
    // Display validation errors if there are any
    if (!empty($errors)) {
        echo "<p>Error(s) occurred during login:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>

    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>
