<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Your Profile</h1>
    <?php
    // Start the session (if not already started)
    session_start();

    // Check if the user is logged in. If not, redirect to the login page.
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    // Include the database connection file
    require_once "db_connection.php";

    // Retrieve the user's data from the database
    $username = $_SESSION["username"]; // Assuming the username is stored in the session after successful login

    $stmt = $connection->prepare("SELECT username, address, phone, email, gender FROM sport WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();
    ?>

    
<table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Username:</td>
            <td><?php echo $user_data["username"]; ?></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><?php echo $user_data["address"]; ?></td>
        </tr>
        <tr>
            <td>Phone Number:</td>
            <td><?php echo $user_data["phone"]; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $user_data["email"]; ?></td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td><?php echo $user_data["gender"]; ?></td>
        </tr>
    </table>

    <!-- Buttons for Edit and Delete -->
    <p class="center">
        <a href="edit_profile.php"><button>Edit</button></a>
        <form method="post" action="delete_profile.php" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <input type="hidden" name="username" value="<?php echo $user_data["username"]; ?>">
            <input type="submit" value="Delete">
        </form>
    </p>

    <p class="center"><a href="homepage.php">Back to Homepage</a></p>
</body>
</html>