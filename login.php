<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database credentials
    $servername = "localhost";
    $username_db = "your_username";
    $password_db = "your_password";
    $dbname = "your_database_name";

    // Create a connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve the user data from the database
    $sql = "SELECT * FROM users WHERE username = '$username'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the user exists and the password is correct
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables and redirect to the dashboard or any other logged-in page
            $_SESSION["username"] = $username;
            $_SESSION["userId"] = $row["user_id"];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $loginError = "Invalid username or password.";
        }
    } else {
        // User does not exist
        $loginError = "Invalid username or password.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
</head>
<body>
  <h2>Login</h2>
  <?php
  if (isset($loginError)) {
      echo '<p style="color: red;">' . $loginError . '</p>';
  }
  ?>
  <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
  </form>
</body>
</html>
