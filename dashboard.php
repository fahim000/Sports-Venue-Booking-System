<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
</head>
<body>
  <h2>Welcome to the Dashboard</h2>
  <?php
  session_start();

  // Check if the user is logged in
  if (isset($_SESSION["username"])) {
      $username = $_SESSION["username"];
      $userId = $_SESSION["userId"];
      echo "<p>Welcome, $username!</p>";
      echo "<p>User ID: $userId</p>";

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

      // Retrieve all logged-in users
      $sql = "SELECT * FROM users";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<h3>Logged-in Users:</h3>";
          echo "<table>";
          echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Gender</th><th>Age</th><th>Action</th></tr>";

          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>".$row["user_id"]."</td>";
              echo "<td>".$row["username"]."</td>";
              echo "<td>".$row["email"]."</td>";
              echo "<td>".$row["gender"]."</td>";
              echo "<td>".$row["age"]."</td>";
              echo "<td><a href='edit.php?id=".$row["user_id"]."'>Edit</a> | <a href='delete.php?id=".$row["user_id"]."'>Delete</a></td>";
              echo "</tr>";
          }

          echo "</table>";
      } else {
          echo "No logged-in users found.";
      }

      // Close the database connection
      $conn->close();
  } else {
      // Redirect to the login page if the user is not logged in
      header("Location: login.php");
      exit();
  }
  ?>
  <p><a href="logout.php">Logout</a></p>
</body>
</html>
