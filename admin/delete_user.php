<?php
// Check if the userId parameter is set in the POST request
if(isset($_POST['userId'])) {
    // Include the database connection script
    require_once "includes/db.php";

    // Sanitize the userId to prevent SQL injection
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    // Prepare and execute the SQL query to delete the user
    $query = "DELETE FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if($result) {
        // Send a success response
        http_response_code(200);
        echo "User deleted successfully.";
    } else {
        // Send an error response
        http_response_code(500);
        echo "Error deleting user: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If userId parameter is not set, send a bad request response
    http_response_code(400);
    echo "Bad request: userId parameter is missing.";
}
?>
