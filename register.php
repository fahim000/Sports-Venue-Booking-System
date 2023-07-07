<?php
// Database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $password = $_POST["password"];

    // SQL query to insert the user data into the database
    $sql = "INSERT INTO users (first_name, last_name, email, username, gender, age, password)
            VALUES ('$firstName', '$lastName', '$email', '$username', '$gender', '$age', '$password')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
