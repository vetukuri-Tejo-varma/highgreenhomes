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
    $id = sanitize($_POST['id']);
    $firstname = sanitize($_POST['firstname']);
    $lastname = sanitize($_POST['lastname']);
    $mobilenumber = sanitize($_POST['mobilenumber']);
    $email = sanitize($_POST['email']);
    $message = sanitize($_POST['message']);



    // Prepare the SQL statement to insert the chat data
    $sql_insert = "INSERT INTO contact_details (id, firstname, lastname,email,message mobilenumber,) 
                     VALUES ('$id', '$firstname', '$lastname','$email','$message','$mobilenumber')";

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