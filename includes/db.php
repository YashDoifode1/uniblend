<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "twitter";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo '<script>alert("User Is  Not created successfully");</script>'; 
}