<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <?php
    // Include the database connection file
    require_once "db_connection.php";

    // Initialize variables to hold user input
    $username = $address = $phone = $email = $gender = "";

    // Validation and form submission handling
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data without sanitizing (remember to use proper sanitization and validation in production)
        $username = $_POST["username"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Validate input
        $errors = [];

        if (empty($username)) {
            $errors[] = "Username is required.";
        }

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

        if (empty($password) || empty($confirm_password)) {
            $errors[] = "Please fill out both password fields.";
        } elseif ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($errors)) {
            // Prepare and execute the query to insert the user into the database
            $stmt = $connection->prepare("INSERT INTO users (username, password, address, phone, email, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $address, $phone, $email, $gender);

            if ($stmt->execute()) {
                echo "Sign up successful!";
                // Redirect to the homepage or any other appropriate page
                header("Location: homepage.php");
                exit(); // Make sure to exit after the redirection
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

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password"><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
