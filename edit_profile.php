<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
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

    // Fetch the current user data
    $stmt = $connection->prepare("SELECT username, address, phone, email, gender FROM sport WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();

    // Initialize variables to hold user input and set them to the current user data
    $address = $phone = $email = $gender = "";
    $address = $user_data["address"];
    $phone = $user_data["phone"];
    $email = $user_data["email"];
    $gender = $user_data["gender"];

    // Validation and form submission handling
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data without sanitizing (remember to use proper sanitization and validation in production)
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];

        // Validate input
        $errors = [];

        if (empty($address)) {
            $errors[] = "Address is required.";
        }

        if (empty($phone)) {
            $errors[] = "Phone number is required.";
        } elseif (!preg_match("/^0[01]\d{9}$/", $phone)) {
            $errors[] = "Invalid phone number. The number should start with 0 or 1 and have 11 digits in total.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($gender)) {
            $errors[] = "Gender is required.";
        }

        if (empty($errors)) {
            // Update the user's data in the database
            $stmt = $connection->prepare("UPDATE sport SET address = ?, phone = ?, email = ?, gender = ? WHERE username = ?");
            $stmt->bind_param("sssss", $address, $phone, $email, $gender, $username);

            if ($stmt->execute()) {
                echo "Profile updated successfully!";
                // You can redirect to the profile page or any other appropriate page after updating the profile.
                // header("Location: profile.php");
                // exit();
            } else {
                echo "Error occurred. Please try again later.";
            }

            $stmt->close();
        } else {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $username; ?>"><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $address; ?>"><br>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>"><br>

        <label for="gender">Gender:</label>
        <input type="radio" name="gender" value="male" <?php if ($gender === "male") echo "checked"; ?>> Male
        <input type="radio" name="gender" value="female" <?php if ($gender === "female") echo "checked"; ?>> Female
        <input type="radio" name="gender" value="other" <?php if ($gender === "other") echo "checked"; ?>> Other<br>

        <input type="submit" value="Save Changes">
    </form>

    <p><a href="profile.php">Back to Profile</a></p>
</body>
</html>
