<?php
require "..\includes/db.php";
?>

<?php
// Assuming you have initialized database connection and sanitized input

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the postId from the AJAX request
    $postId = $_POST["postId"];

    // Update the likes in the database
    $sql = "UPDATE posts SET likes = likes - 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    
    if ($stmt->execute()) {
        // Fetch the updated likes count
        $sql = "SELECT likes FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $likesCount = $row['likes'];

        echo json_encode(array("message" => "Likes updated successfully", "likesCount" => $likesCount));
    } else {
        echo json_encode(array("error" => "Error updating likes: " . $conn->error));
    }

    $stmt->close();
}

// Close database connection if needed
$conn->close();
?>

