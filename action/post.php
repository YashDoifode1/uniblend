<?php require "..\includes/header.php"; ?>
<?php require "..\includes/db.php"; ?>
<?php
 // Start session to get session ID
 
 //session_start();
 
 // Check if the user is not logged in
 if (!isset($_SESSION['username'])) {
     // Redirect the user to the login page
     header("Location: login.php");
     exit(); // Stop further execution
 }

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Database connection
   

    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $username = $_SESSION['username'];
    $session_id = session_id();

    // Upload image
    $target_dir = "..\uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo '<script>alert("The file ' . htmlspecialchars(basename($_FILES["image"]["name"])) . ' has been uploaded.");</script>';
        } else {
          echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
        }
    }
    // Prepare SQL statement to insert data into the posts table
    $sql = "INSERT INTO posts (title, description, image, username, category, session_id) VALUES ('$title', '$description', '$target_file', '$username', '$category', '$session_id')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Post created successfully");</script>';
        header("location: " . APP_URL ."index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <style>
        /* Embedded CSS */
        form {
            width: 50%;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .back-button {
            background-color: #ccc;
            color: #333;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .back-button:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <center><h2>Create Post</h2></center>
    <form action="<?php echo APP_URL;?>action/post.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="category">Category:</label><br>
        <select name="category" required>
                <option value="">Select Category</option>
                <?php
                // Fetch categories from database
                $conn = new mysqli('localhost', 'root', '', 'twitter');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT id, name FROM categories";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }
                $conn->close();
                ?>
            </select><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br> </br>
        <input type="submit" name="submit" value="Create Post">
        <a href="<?php echo APP_URL;?>index.php" class="back-button">Back</a>
    </form>
    <br>
</body>
</html>
<?php require "..\includes/footer.php"; ?>





