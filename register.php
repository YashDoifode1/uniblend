<?php
if(isset($_POST['submit'])) {
    // Establish database connection (assuming you have already done this)
    require "includes/db.php";

    // Fetching user data from the form
    if(isset($_POST['submit'])) {
      // Establish database connection (assuming you have already done this)
      require "includes/db.php";
  
      // Fetching user data from the form
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $bio = $_POST['bio'];
      // Handle selected categories
      $categories = isset($_POST['categories']) ? $_POST['categories'] : array();
  
      // Convert categories array to comma-separated string
      $categoriesString = implode(", ", $categories);

    // Validate data (you should add more validation as per your requirements)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Image processing and storage
    $target_directory = "Images/";
    $target_file = $target_directory . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename( $_FILES["image"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }
  }

    // Prepare SQL statement to insert data into the users table
    $sql = "INSERT INTO users (email, username, password, bio, profile_image, category) 
            VALUES ('$email', '$username', '$password','$bio', '$target_file', '$categoriesString')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("User created successfully");</script>'; // Display JavaScript alert
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close database connection
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="css/reg.css">
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>
  <br>
  <div class="profile-container">
    <img src="Images/logo.jpeg" alt="Profile Picture">
  </div>
  <div class="register-container">
    <h2>Register New User</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="bio">Bio</label>
        <input type="text" id="bio" name="bio" required>
      </div>
      <div class="form-group">
        <label for="image">Choose Profile Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
      </div>
      <div class="form-group">
        <label for="categories">Categories</label><br>
        <input type="checkbox" id="category1" name="categories[]" value="Marvel ">
        <label for="Marvel">Marvel</label><br>
        <input type="checkbox" id="category2" name="categories[]" value="DC">
        <label for="category2">DC</label><br>
        <input type="checkbox" id="category3" name="categories[]" value="Anime ">
        <label for="Marvel">Anime</label><br>
        <input type="checkbox" id="category4" name="categories[]" value="KPOP">
        <label for="category2">KPOP</label><br>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" name="submit">Register</button>
    </form>
  </div>
</body>
</html>