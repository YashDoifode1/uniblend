


<?php
// Connect to the database (assuming you have a connection script)
require_once "includes/db.php";
require_once "includes/header.php";
?>


<?php
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
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
            width: 500px; /* Set the width of the user details container */
        }
        .user-details h2 {
            margin-top: 0;
        }
        .user-details p {
            margin-bottom: 5px;
        }
        .action-buttons button {
            display: block; /* Make buttons block-level elements */
            width: 80%; /* Set buttons to take up full width */
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px; /* Add margin between buttons */
        }
        .send-message-button {
            background-color: red;
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
        .del-user-button {
            background-color: #dc3545;
            color: #fff;
        }
        .del-user-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <br>
    <center>User Monitoring</center>
    <br>
    <?php
// Check if there are any users
if ($result->num_rows > 0) {
    // Start the table
    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    // Add table headers
    echo '<tr>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">ID</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Username</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Email</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Profile Image</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Reports</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Action</th>';
    echo '</tr>';

    // Loop through each user and display their details in a table row
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        // Display username and email in table cells
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row['id'] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row['username'] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row['email'] . '</td>';
        // Display profile image if available
        echo '<td style="border: 1px solid #ddd; padding: 8px;">';
        if (!empty($row['profile_image'])) {
            echo '<img src="' . $row['profile_image'] . '" alt="Profile Image" style="max-width: 100px;">';
        }
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row['report'] . '</td>';
        echo '</td>';
        // Display action buttons in the last cell
        echo '<td style="border: 1px solid #ddd; padding: 8px;">';
        echo '<button style="padding: 5px 10px; background-color: #007bff; color: #fff; border: none; cursor: pointer; border-radius: 4px;" onclick="viewProfile(\'' . $row['id'] . '\')">View Profile</button>';
        echo '<button style="margin-left: 5px; padding: 5px 10px; background-color: #dc3545; color: #fff; border: none; cursor: pointer; border-radius: 4px;" onclick="deleteUser(\'' . $row['id'] . '\')">Delete</button>';
        echo '</td>';
        echo '</tr>';
    }
    // Close the table
    echo '</table>';
} else {
    // No users found
    echo '<p>No users found.</p>';
}
?>




    <!-- Add more HTML content as needed -->

    <script>
        // JavaScript function to handle viewing user profiles
        function viewProfile(id) {
            // Redirect to the user's profile page
            window.location.href = "account.php?id=" + id;
        }

        // JavaScript function to handle deleting a user
        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                // Send AJAX request to delete the user
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_user.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Reload the page after successful deletion
                        location.reload();
                    }
                };
                xhr.send("userId=" + userId);
            }
        }
    </script>
</body>
</html>







