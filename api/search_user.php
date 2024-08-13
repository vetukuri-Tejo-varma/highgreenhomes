<?php
// search_user.php

// Include the database configuration file
require_once 'config.php';

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the user phone number from the POST request and sanitize it
    $user_phone = sanitize($_POST['user_phone']);

    // Query to search for the user by phone number
    $sql_search = "SELECT * FROM highgreen_users WHERE user_phone = '$user_phone'";
    $result_search = $conn->query($sql_search);

    if ($result_search && $result_search->num_rows > 0) {
        // If the user is found, fetch the data
        $user_data = $result_search->fetch_assoc();

        $response = array(
            "status" => "success",
            "message" => "User found.",
            "data" => array(
                "user_name" => $user_data['user_name'],
                "user_email" => $user_data['user_email'],
                "user_phone" => $user_data['user_phone'],
                "device_id" => $user_data['device_id']
            )
        );
    } else {
        // If the user is not found, return a not created message
        $response = array(
            "status" => "error",
            "message" => "User is not created."
        );
    }

    // Close the database connection
    $conn->close();

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
