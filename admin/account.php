<?php require "includes/header.php"; ?>
<?php require "includes/db.php"; ?>
<?php


// Assuming you have a database connection established already
 // Include your database connection script

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user information
    $userQuery = "SELECT * FROM users WHERE id = '$id'";
    $userResult = $conn->query($userQuery);
    $userData = $userResult->fetch_assoc();

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page </title>
    <!-- Add your CSS styles here -->
    <style>
        /* Sample CSS for demonstration */
        .user-info-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .user-info-container h2 {
            margin-top: 0;
        }
        .user-info-container p {
            margin-bottom: 5px;
        }
        .settings-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .settings-button:hover {
            background-color: #0056b3;
        }
        .post {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        span{
            color:red;
        }
        #green {
            color: green;
            font-weight: bold;
        }
        #grey {
            color: grey;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <br>
    

    <!-- Display user information -->
    <center><div class="user-info-container">
        <h2>User Information:</h2><br>
       <?php if (!empty($userData['profile_image'])) {
                echo '<img src="' . $userData['profile_image'] . '" alt="Profile Image">';
            } ?>
        <p>Username: <span id='green'><?php echo $userData['username']; ?></span></p>
        <p>Email:<span id='green'> <?php echo $userData['email']; ?></span></p>
        <p>Description :<span id='grey'> <?php echo $userData['bio']; ?></span></p><br>
        <button class="send-message-button" style="padding: 10px;background-color: blue; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;" onclick="sendMessage(<?php echo $userData['username']; ?>)">Send Message</button>
        <button class="send-message-button" style="padding: 10px;background-color: grey; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;" onclick="sendMessage(<?php echo $userData['username']; ?>)">Send Request</button>
        <a href="users.php" style="padding: 10px;background-color: red; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;"> Users Page  </a>'
        <!-- Add more user information fields as needed -->
       
        <p>
    </div></center>
    <!-- Add more user information fields as needed -->

    <!-- Display user's posts -->
    <h2>Your Posts:</h2>
    <?php
    $username = $userData['username'];
    // Fetch user's posts
    $postQuery = "SELECT * FROM posts WHERE username = '$username'";
    $postResult = $conn->query($postQuery);
    if ($postResult->num_rows > 0) {
        while ($post = $postResult->fetch_assoc()) {
            echo '<center><div class="post">';
            echo '<img src="' . $post['image'] . '" alt="Profile Image">';
            echo '<h3>' . $post['title'] . '</h3>';
            echo '<p>' . $post['description'] . '</p>';
            echo '<p> Likes :' . $post['likes'] . '</p>';
            echo '<a href="single.php?id=' . $post["id"] . '"  style="padding: 10px;background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;"> View </a>';
            // Add more post details as needed
            //Extra Code Here 
            

            //Ends Here
            echo '</div></center>';
        }
    } else {
        echo '<script>alert("No posts found")</script>';
    }
    ?>

    <!-- Add more HTML content as needed -->

</body>
</html>

<?php require "includes/footer.php";
?>


