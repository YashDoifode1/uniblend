<?php require "includes/header.php"; ?>
<?php require "includes/db.php"; ?>
<?php 
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        } 
        .container1 {
            /* max-width: 800px;
            margin: 50px auto; */
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .post {
            max-width: 800px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        .post img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
            border-radius: 5px;
        }
        .post h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .post p {
            color: #666;
            display: none; /* Initially hide description */
        }
        /* Icon styles */
        .icon-button {
            font-size: 24px;
            margin-left: 10px;
            cursor: pointer;
            padding: 10px;
        }
        .icon-button:hover {
            color: pink;
        }
        .icon-button:active {
            color: brown;
        }
        .red { color: red; }
        .blue { color: blue; }
        .black { color: black; }
        .grey { color: grey; }
        .icon-text {
            margin-left: 5px;
        }
        span {
            margin-left: 10px;
        }
    </style>
</head>

<body>
<br>
<div id="searchResults"></div>
<?php
// Query to fetch posts from the database
$sql = "SELECT * FROM posts ORDER BY created_at DESC"; // Assuming 'created_at' is the column representing the creation date of posts
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="post">';
        echo '<img src="' . $row["image"] . '" alt="' . $row["title"] . '">';
        echo '<h2>' . $row["title"] . '</h2>';
        echo '<p>' . $row["description"] . '</p>';
        // echo '<center>';
        echo '<i class="fas fa-info-circle icon-button green" title="Description" onclick="toggleDescription(this)"></i>';
        echo '<a href="' . APP_URL . 'action/single.php?id=' . $row["id"] . '" class="icon-button red" title="Comments"><i class="fas fa-comments"></i></a>';
        echo '<i class="fas fa-share-alt icon-button grey" title="Share" id="copyButton" onclick="copyLink(' . $row["id"] . ')"></i>';
        ?>
        <input type="text" value="<?php echo APP_URL; ?>action/single.php?id=<?php echo $row["id"] ?>" id="shareLink_<?php echo $row['id']; ?>" style="display: none;">
        <?php
        echo '<i class="fas fa-thumbs-up icon-button blue" data-id="' . $row["id"] . '" onclick="likes(' . $row["id"] . ')" title="Like"></i>';
        echo '<i class="fas fa-thumbs-down icon-button black" data-id="' . $row["id"] . '" onclick="hate(' . $row["id"] . ')" title="Hate"></i>';
        echo '<span id="likeCount_' . $row["id"] . '">' . $row["likes"] . '</span>';
        // echo '</center>';
        echo '</div>';
    }
} else {
    echo '<script>alert("No data found!");</script>';
}
$conn->close();
?>

<div id="searchResults"></div>

<script>
// Function to toggle visibility of post description
function toggleDescription(element) {
    var description = element.parentElement.querySelector('p');
    description.style.display = (description.style.display === 'none') ? 'block' : 'none';
}

// Function to copy the share link
function copyLink(postId) {
    var shareLink = document.getElementById('shareLink_' + postId);
    shareLink.style.display = "block";
    shareLink.select();
    document.execCommand("copy");
    shareLink.style.display = "none";
    alert("Link copied to clipboard!");
    location.reload();
}

// Function to handle likes
function likes(postId) {
    $.ajax({
        type: 'POST',
        url: '<?= APP_URL ?>action/update.php',
        data: { postId: postId },
        dataType: 'json', // Specify JSON dataType for parsing response
        success: function(response) {
            var likeCountSpan = document.getElementById('likeCount_' + postId);
            likeCountSpan.textContent = response.likesCount;
            console.log(response.message);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Function to handle hate
function hate(postId) {
    $.ajax({
        type: 'POST',
        url: '<?= APP_URL ?>action/hate.php',
        data: { postId: postId },
        dataType: 'json', // Specify JSON dataType for parsing response
        success: function(response) {
            var likeCountSpan = document.getElementById('likeCount_' + postId);
            likeCountSpan.textContent = response.likesCount;
            console.log(response.message);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
</script>

</body>
</html>

<?php require "includes/footer.php"; ?>
