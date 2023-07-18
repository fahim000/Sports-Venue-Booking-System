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

    // Validation and login handling
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data without sanitizing (remember to use proper sanitization and validation in production)
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate input
        $errors = [];

        if (empty($username) || empty($password)) {
            $errors[] = "Username and password are required.";
        }

        if (empty($errors)) {
            // Prepare and execute the query to check if the user exists in the database
            $stmt = $connection->prepare("SELECT username, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user["password"])) {
                // Successful login, redirect to the homepage or any other appropriate page
                header("Location: homepage.php");
                exit();
            } else {
                $errors[] = "Invalid username or password. Please try again.";
            }
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

        <p><?php echo implode("<br>", $errors); ?></p>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </form>
</body>
</html>
