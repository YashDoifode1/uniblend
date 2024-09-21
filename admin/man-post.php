<?php require "includes/header.php"; ?>
<?php require "includes/db.php";?>
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
    <style>
        /* Embedded CSS
            .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }*/
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        } 
        .container1 {
            max-width: 800px;
            margin: 50px auto;
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
        .show-description {
            background-color: #4CAF50;
            color: white;
            margin-left:10px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        button:hover{
            background-color:pink;
        }
        button:active{
            background-color:brown;
        }

        .red{
            margin-left: 10px;
            color: white;
            background: red;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .blue{
            margin-left: 10px;
            color: white;
            background: blue;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .black{
            margin-left: 10px;
            color: white;
            background: black;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .grey{
            margin-left: 10px;
            color: white;
            background: grey;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        span{
            margin-left: 10px;
              
        } </style>


</head>

<body>
<br>
<div id="searchResults"></div>
<br>

<br>
<?php
// Query to fetch posts from the database
$sql = "SELECT p.*, COUNT(c.id) AS comment_count FROM posts p LEFT JOIN comments c ON p.id = c.post_id GROUP BY p.id ORDER BY p.created_at DESC"; // Assuming 'created_at' is the column representing the creation date of posts
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the table
    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    // Add table headers
    echo '<tr>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">ID</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Title</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Comments</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Likes</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Reports</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Actions</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Actions</th>';
    echo '</tr>';

    // Loop through each post and display its details in a table row
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        // Display post details in table cells
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["id"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["title"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["description"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["comment_count"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["likes"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["report"] . '</td>';
        // Action buttons
        echo '<td style="border: 1px solid #ddd; padding: 8px;">';
        
        echo '<button class="btn-delete" value='. $row["id"] .' style="padding: 5px 10px; background-color: red; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 5px;">Delete</button>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">';
        echo '<button class="btn-view" value='. $row["id"] .' style="padding: 5px 10px; background-color: blue; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 5px;">View</button>';
        echo '</td>';
        echo '</tr>';
    }
    // Close the table
    echo '</table>';
} else {
    // No posts found
    echo '<p>No posts found.</p>';
}
$conn->close();
?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Submit comment form via AJAX
    $('.btn-delete').on('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        var id = $(this).val(); // Get comment ID to delete

        $.ajax({
            type: 'POST',
            url: 'del-post.php',
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



</body>

</html>


