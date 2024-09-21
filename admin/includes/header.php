<?php 
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown tools-menu">
                    <a href="javascript:void(0)" class="dropbtn">Tools</a>
                    <div class="dropdown-content">
                        <a href="cat.php">Category</a>
                        <a href="users.php">Users</a>
                        <a href="man-post.php">Manage Posts</a>
                        <a href="com.php">Comments</a>
                        <a href="post.php">Add Post</a>
                    </div>
                </li>
                <li class="dropdown user-menu">
                    <a href="javascript:void(0)" class="dropbtn"><?php echo htmlspecialchars($username); ?></a>
                    <div class="dropdown-content">
                        <?php if($username !== 'Guest'): ?>
                            <a href="set.php">Change Password</a>
                            <a href="logout.php">Logout</a>
                        <?php else: ?>
                            <a href="login.php">Login</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
</body>
</html>
