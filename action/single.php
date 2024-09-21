


<?php require "..\includes/header.php"; ?>
<?php require "..\includes/db.php"; ?>
<?php



// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

// single.php

// Include your database connection code here

// Check if the post ID is provided in the URL
if(isset($_GET['id'])) {
    $post_id = $_GET['id'];
    
    // Query to fetch the post details from the database
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch post data
        $post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Post</title>
    <style>
        
        span{
            color:red;
        }

        .container1 {
            max-width: 800px;
            margin: 0 auto;
        }

        .post {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        
        }

        .post img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .comments {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
        }

        .comment {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .comment strong {
            font-weight: bold;
        }

        .comment p {
            margin: 0;
        }

        .comment textarea {
            width: 100%;
            padding: 5px;
            margin-top: 10px;
        }

        .comment button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .comment button:hover {
            background-color: #0056b3;
        }

        .red{
            background:red;
        }
        button:hover{
            background:blue;

        }
        button:active{
            background:green;
        }
        #btn:hover {
    background-color: darkred; /* Change the background color on hover */
}

    </style>
</head>
<body>
    <br>
    <div class="container1">
        <div class="post">
            <h5> User: <span><?php echo $post['username']; ?></span></h5>
            <h1><?php echo $post['title']; ?></h1>
            <img src="<?php echo APP_URL; ?><?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
            <p><?php echo $post['description']; ?></p>
            <p>Likes: <?php echo $post['likes']; ?></p>
        </div>

        <div class="comments">
            <h2>Comments</h2>
            <!-- Display existing comments here -->
            <!-- Example: -->
            <div class="comments">
            <?php
$sql = "SELECT * FROM comments WHERE post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
        echo '<h2>' . $row["username"] . '</h2>';
        
        echo '<p>' . $row["Created"] . '</p>';
        echo '<h5>' . $row["comment"] . '</h5>';
        if(isset($_SESSION['username']) AND $_SESSION['username']== $row['username']):
            echo '<button class="btn-delete" value='. $row["id"] .' style="padding: 10px;background-color: red; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Delete</button>';
        endif;
        echo '</div>'; // Added semicolon to end the echo statement
    }

} else {
//echo '<script>alert("NO data Found !");</script>'; 
}
$conn->close();
?>
            

            <!-- Form to add a new comment -->
            <form id="comment-form">
                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                <input type="hidden" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
                <textarea name="comment" placeholder="Your Comment" style="width: 100%; padding: 10px; margin-top: 20px; border: 1px solid #ccc; border-radius: 5px;" required></textarea>
    <!-- Button to submit the comment -->
    <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">Comment</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
    } else {
        echo '<p>Post not found.</p>';
    }
} else {
    echo '<p>Post ID not provided.</p>';
}
?>
<?php require "..\includes/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Submit comment form via AJAX
    $('.btn-delete').on('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        var id = $(this).val(); // Get comment ID to delete

        $.ajax({
            type: 'POST',
            url: '<?= APP_URL ?>action/del-com.php',
            data: {
                delete: 'delete',
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Alert success
                    alert('Comment deleted successfully!');
                    // Reload the page
                    location.reload();
                } else {
                    console.error('Error:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });
});
</script>

<!-- ----------------------------------------------------------------------------------------- -->
<script>
       
        // Submit comment form via AJAX
        $('#comment-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: 'POST',
                url: '<?= APP_URL ?>action/comment.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Alert success
                        alert('Comment added successfully!');
                        // Reload the page
                        location.reload();
                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                }
                // Function to load comments
        
        });

        // Function to load comments
        // function loadComments() {
        //     var postId = <?php echo $post_id; ?>;
        //     $.ajax({
        //         type: 'GET',
        //         url: 'omments.php?id=' + postId,
        //         dataType: 'html',
        //         success: function(response) {
        //             $('#comments-list').html(response);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error:', xhr.responseText);
        //         }
        //     });
        // }

        // // Load comments initially
        // loadComments();
    });
   
</script>

