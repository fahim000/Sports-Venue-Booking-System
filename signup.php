<?php
// Include the database connection file
require_once 'db_connection.php';

// Define variables to store user inputs and error messages
$username = $email = $password = $confirm_password = '';
$username_err = $email_err = $password_err = $confirm_password_err = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } else {
        // Prepare a select statement to check if the username already exists
        $sql = 'SELECT id FROM users WHERE username = ?';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('s', $param_username);

            // Set parameter values and execute the statement
            $param_username = trim($_POST['username']);

            if ($stmt->execute()) {
                // Check if the username already exists
                if ($stmt->fetch()) {
                    $username_err = 'This username is already taken.';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter an email address.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm the password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare an insert statement
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sss', $param_username, $param_email, $param_password);

            // Set parameter values and hash the password
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the login page after successful registration
                header('location: login.php');
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
    <title>Sign Up</title>
    <style>
        .wrapper { width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span><?php echo $email_err; ?></span>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php echo $password; ?>">
                <span><?php echo $password_err; ?></span>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
