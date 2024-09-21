<?php require "includes/header.php"; ?>
<?php require "includes/db.php"; ?>
<?php
// Start session
//session_start();

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Query the database for the user
    $query = "SELECT * FROM users WHERE username = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Login successful
        $userData = $result->fetch_assoc();
        $_SESSION['id'] = $userData['id']; // Assuming 'id' is the user ID column in your database
        $_SESSION['username'] = $email;

        echo "Login successful";
        header("Location: index.php");
        exit();
    } else {
        // Login failed
        echo "Invalid username or password";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UniBlend Login</title>
  <link rel="stylesheet" href="css/log.css">
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>
  <br>
  <div class="profile-container">
    <img src="Images/logo.jpeg" alt="Profile Picture">
    <p><b>Welcome to our website! Please log in to continue.</b></p>
  </div><br>
  <div class="login-container">
    <h2>Please sign in</h2>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="email">Username</label>
        <input type="text" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Sign In</button><br>
      <div class="noAcc">
        <br>
          <p>Don't have an account  <a href="register.php">Create your account</a></p> 
        </div>
    </form>
  </div>
</body>
</html>


