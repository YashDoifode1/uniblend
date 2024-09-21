<?php

require_once 'vendor/autoload.php'; // Include the JWT library

use \Firebase\JWT\JWT; // Import the JWT class

// Ensure the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Validate form data
    $errors = [];
    
    // Validate topic
    $topic = trim($_POST['topic']);
    if (empty($topic)) {
        $errors[] = "Meeting topic is required.";
    }
    
    // Validate start time
    $start_time = trim($_POST['start_time']);
    if (empty($start_time)) {
        $errors[] = "Start time is required.";
    }
    
    // Validate duration
    $duration = trim($_POST['duration']);
    if (empty($duration) || !is_numeric($duration)) {
        $errors[] = "Duration must be a valid number.";
    }
    
    // If there are validation errors, return them as JSON response
    if (!empty($errors)) {
        http_response_code(400); // Bad request
        echo json_encode(['errors' => $errors]);
        exit;
    }
    
    // API key and secret key
    $api_key = 'Z7UYil0ETjKkrSbYK6ggng';
    $api_secret = 'PhUlD4I3PSyfcWmmLON2dipWftEagOHL';
    
    // Create a JWT token
    $payload = [
        'iss' => $api_key,
        'exp' => strtotime('+1 hour')
    ];

    $jwt = JWT::encode($payload, $api_secret);

    // Create a new meeting
    $data = [
        'topic' => $topic,
        'type' => 2, // Scheduled meeting
        'start_time' => $start_time,
        'duration' => $duration,
    ];
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.zoom.us/v2/users/me/meetings',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json'
        ],
    ]);
    
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);
    
    // Check if the request was successful
    if ($http_code === 201) { // 201 Created
        $meeting_data = json_decode($response, true);
        echo json_encode(['success' => true, 'meeting' => $meeting_data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create meeting.']);
    }
    
} else {
    // If the request method is not POST, return an error
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
}

?>
