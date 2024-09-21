<?php
require "includes/header.php";
require "includes/db.php";

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
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Assuming category is selected from a dropdown

    // Upload image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "twitter");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement to insert data into the posts table
    $sql = "INSERT INTO posts (title, description, image, category, username) 
            VALUES ('$title', '$description', '$target_file', '$category', '{$_SESSION['username']}')";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Post created successfully");</script>';
        header("location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
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
    <form action="post.php" method="post" enctype="multipart/form-data">
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
        <a href="index.php" class="back-button">Back</a>
    </form>
</body>
</html><br>
<?php require "includes/footer.php"; ?>





