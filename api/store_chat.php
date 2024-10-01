<?php
require_once "config.php"; // Include the database configuration file

header('Content-Type: application/json');

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $user_id = sanitize($_POST['user_id']);
    $mobile_number = sanitize($_POST['mobile_number']);
    $message = sanitize($_POST['message']);
    $timestamp = date('Y-m-d H:i:s'); // Get the current timestamp
    $email = sanitize($_POST['email']);
    $name = sanitize($_POST['name']);
    $lastname = sanitize($_POST['lastname']);
    $firstname = sanitize($_POST['firstname']);
    $type = sanitize($_POST['type']);


    // Prepare the SQL statement to insert the chat data
    $sql_insert = "INSERT INTO chat_data (user_id, mobile_number, message, timestamp,name,email,lastname,firstname,type) 
                   VALUES ('$user_id', '$mobile_number', '$message', '$timestamp','$name','$email','$lastname','$firstname','$type')";

    // Execute the query and check for success
    if ($conn->query($sql_insert) === TRUE) {
        $response = array(
            "status" => "success",
            "message" => "Chat data stored successfully."
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Error: " . $sql_insert . "<br>" . $conn->error
        );
    }

    // Close the database connection
    $conn->close();

    // Return the response as JSON
    echo json_encode($response);
} else {
    // Return an error response for invalid request methods
    $response = array(
        "status" => "error",
        "message" => "Invalid request method. Please use POST."
    );
    echo json_encode($response);
}
?>