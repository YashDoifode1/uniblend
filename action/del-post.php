<?php require "..\includes/db.php"; ?>


<?php
// Assuming you have a database connection
// Include your database connection code here

// Check if the delete action is requested
if(isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Perform the deletion query
    // Replace 'comments_table' with your actual table name
    $sql = "DELETE FROM posts WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error", "message" => "Error deleting record: " . $conn->error);
    }

    // Close database connection
    // $conn->close();

    echo json_encode($response);
} else {
    // If the delete action is not requested properly, return an error response
    $response = array("status" => "error", "message" => "Invalid request");
    echo json_encode($response);
}
?>

