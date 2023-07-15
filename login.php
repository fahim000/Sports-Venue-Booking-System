<?php
// Include the database connection file
require_once 'db_connection.php';

// Define variables to store user inputs and error messages
$username = $password = '';
$username_err = $password_err = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter your username.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check input errors before verifying the credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement to retrieve the user record
        $sql = 'SELECT id, username, password FROM users WHERE username = ?';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('s', $param_username);

            // Set parameter values and execute the statement
            $param_username = $username;

            if ($stmt->execute()) {
                $stmt->store_result();

                // Check if the username exists, if yes, verify the password
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;

                            // Redirect to the home page or dashboard
                            header('location: index.php');
                        } else {
                            // Display an error message if the password is not valid
                            $password_err = 'The password you entered is not valid.';
                        }
                    }
                } else {
                    // Display an error message if the username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        .wrapper { width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to log in.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
