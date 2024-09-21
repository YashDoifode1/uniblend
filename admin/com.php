<?php require "includes/header.php"; ?>
<?php require "includes/db.php"; ?>

<?php
// Query to fetch comments from the database
$sql = "SELECT * FROM comments "; // Assuming 'created_at' is the column representing the creation date of comments
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the table
    echo '<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">';
    // Add table headers
    echo '<tr>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Post ID</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Comment</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Author</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Created At</th>';
    echo '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Action</th>';
    echo '</tr>';

    // Loop through each comment and display its details in a table row
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        // Display comment details in table cells
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["post_id"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["comment"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["username"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $row["Created"] . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">';
        
        echo '<button class="btn-delete" value='. $row["id"] .' style="padding: 5px 10px; background-color: red; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 5px;">Delete</button>';
        echo '</tr>';
    }
    // Close the table
    echo '</table>';
} else {
    // No comments found
   echo '<p>No comments found.</p>';
}
$conn->close();
?>