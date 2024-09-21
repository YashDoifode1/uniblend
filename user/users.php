

<?php
// Connect to the database (assuming you have a connection script)
require_once "..\includes/db.php";
require_once "..\includes/header.php";
?>


<?php
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: " . APP_URL . "login.php");
    exit(); // Stop further execution
}

// Fetch all user details from the 'users' table
$query = "SELECT * FROM users ORDER BY created DESC";
$result = $conn->query($query);

// Close the database connection after fetching data
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        /* CSS for demonstration */
        .user-details {
            border: 1px solid #ccc;
            padding: 10px; /* Add padding around each user details container */
            margin-bottom: 20px; /* Add margin between user details containers */
            /* width: 500px; Set the width of the user details container */
        }
        .user-details h2 {
            margin-top: 0;
        }
        .user-details p {
            margin-bottom: 5px;
        }
        .action-buttons button {
            display: block; /* Make buttons block-level elements */
            width: 40%; /* Set buttons to take up full width */
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px; /* Add margin between buttons */
        }
        .send-message-button {
            background-color: #007bff;
            color: #fff;
        }
        .send-message-button:hover {
            background-color: #0056b3;
        }
        .view-profile-button {
            background-color: #28a745;
            color: #fff;
        }
        .view-profile-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <br>
    <?php
    // Check if there are any users
    
    if ($result->num_rows > 0) {
        // Loop through each user and display their details
        echo '<h2>User Information:</h2>';
        while ($row = $result->fetch_assoc()) {
            echo '<center><div class="user-details">';
            
            
            // echo '<p>Email: ' . $row['email'] . '</p>';
            // Add more user details fields as needed
            // Display profile image if available
            if (!empty($row['profile_image'])) {
                echo '<img src="' . APP_URL . $row['profile_image'] . '" alt="Profile Image">';
            } 
            echo '<p>Username: ' . $row['username'] . '</p>';
        
            // Action buttons
            echo '<div class="action-buttons">';
            echo '<button class="send-message-button" onclick="sendMessage(\'' . $row['id'] . '\')">Send Message</button>';
            echo '<button class="view-profile-button" onclick="viewProfile(\'' . $row['id'] . '\')">View Profile</button>';
            echo '</div>';
            echo '</div></center>';
        }
    } else {
        // No users found
        echo '<p>No users found.</p>';
    }
    ?>

    <!-- Add more HTML content as needed -->

    <script>
        // JavaScript function to handle sending message requests
        function sendMessage(id) {
            // Redirect or perform other actions to send a message request
            // For now, let's just alert the username
            alert("Sending message request to " + id);
        }

        // JavaScript function to handle viewing user profiles
        function viewProfile(id) {
        // Redirect to the user's profile page
        window.location.href = "<?= APP_URL ?>user/account.php?id=" + id;
    }
</script>
</body>
</html>

<?php require_once "..\includes/footer.php"; ?>




