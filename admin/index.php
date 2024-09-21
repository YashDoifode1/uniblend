<?php
require "includes/header.php";
require "includes/db.php";

// Start session to get session ID
//session_start();

// // Check if the user is not logged in
// if (!isset($_SESSION['admin'])) {
//     // Redirect the user to the login page
//     header("Location: login.php");
//     exit(); // Stop further execution
// }

// Database connection
$conn = mysqli_connect("localhost", "root", "", "twitter");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch total user count
$userCountQuery = "SELECT COUNT(*) as total_users FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$totalUsers = $userCountRow['total_users'];

// Fetch total post count
$postCountQuery = "SELECT COUNT(*) as total_posts FROM posts";
$postCountResult = mysqli_query($conn, $postCountQuery);
$postCountRow = mysqli_fetch_assoc($postCountResult);
$totalPosts = $postCountRow['total_posts'];

// Fetch total comment count
$commentCountQuery = "SELECT COUNT(*) as total_comments FROM comments";
$commentCountResult = mysqli_query($conn, $commentCountQuery);
$commentCountRow = mysqli_fetch_assoc($commentCountResult);
$totalComments = $commentCountRow['total_comments'];

//Category
$categoryCountQuery = "SELECT category, COUNT(*) as post_count FROM posts GROUP BY category";
$categoryCountResult = mysqli_query($conn, $categoryCountQuery);

// Fetch total admin count
$adminCountQuery = "SELECT COUNT(*) as total_admins FROM admin ";
$adminCountResult = mysqli_query($conn, $adminCountQuery);
$adminCountRow = mysqli_fetch_assoc($adminCountResult);
$totalAdmins = $adminCountRow['total_admins'];

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Embedded CSS */
        .dashboard-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .dashboard-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .dashboard-item h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>

    <br>
    <center><div class="dashboard-container">
    <div class="dashboard-item">
            <h2 style="color:red;">Total Admins :</h2>
            <p><?php echo $totalAdmins; ?></p>
            <button style="padding: 10px;background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 3 px;" onclick="window.location.href='#';">Manage</button>
           
        </div>
        <div class="dashboard-item">
            <h2 style="color:blue;">Total Users :</h2>
            <p><?php echo $totalUsers; ?></p>
            <button style="padding: 10px;background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 3 px;" onclick="window.location.href='users.php';">Manage</button>
            
        </div>
        <div class="dashboard-item">
            <h2 style="color:Green;">Total Posts :</h2>
            <p><?php echo $totalPosts; ?></p>
            <button style="padding: 10px;background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 3 px;" onclick="window.location.href='man-post.php';">Manage</button>
        </div>
        <div class="dashboard-item">
            <h2 style="color: Orange;">Total Comments :</h2>
            <p><?php echo $totalComments; ?></p>
            <button style="padding: 10px;background-color: green; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 3 px;" onclick="window.location.href='com.php';">Manage</button>
            
        </div>
        <!-- <div class="dashboard-item">
            <h2 style="color: blue;"> Category :</h2>
            <ol>
                <?php
                // Display the count of posts per category
                while ($row = mysqli_fetch_assoc($categoryCountResult)) {
                    echo "<li>{$row['category']}: {$row['post_count']}</li>";
                }
                ?>
            </ol>
    </div>--></center> 
</body>
</html>



