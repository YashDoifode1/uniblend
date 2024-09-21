<?php require "..\includes/db.php";?>
<?php
// comment.php

// Include your database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $post_id = $_POST['id'];
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // Your SQL query to insert the comment into the database
    $sql = "INSERT INTO comments (post_id, username, comment) VALUES ('$post_id', '$username', '$comment')";

    if ($conn->query($sql) === TRUE) {
        // Comment inserted successfully
        echo json_encode(array("status" => "success"));
    } else {
        // Error inserting comment
        echo json_encode(array("status" => "error", "message" => $conn->error));
    }

    $conn->close();
} else {
    // Method not allowed
    http_response_code(405);
}
?>
