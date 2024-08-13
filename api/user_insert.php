<?php
// insert_data.php

// Include the database configuration file
require_once 'config.php';

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data and sanitize it
    $user_name = sanitize($_POST['user_name']);
    $user_email = sanitize($_POST['user_email']);
    $user_phone = sanitize($_POST['user_phone']);
    $device_id = sanitize($_POST['device_id']);

    // Check if the mobile number already exists in the database
    $sql_check = "SELECT COUNT(*) as count FROM highgreen_users WHERE user_phone = '$user_phone'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $count = $row['count'];

        if ($count == 0) { // Use == for comparison with integer
            // If the mobile number does not exist, perform the insert
            $sql_insert = "INSERT INTO highgreen_users (user_name, user_email, user_phone, device_id) 
                           VALUES ('$user_name', '$user_email', '$user_phone', '$device_id')";

            if ($conn->query($sql_insert) === TRUE) {
                $response = array(
                    "status" => "success",
                    "message" => "Data inserted successfully.",
                    "data" => array(
                        "user_name" => $user_name,
                        "user_email" => $user_email,
                        "user_phone" => $user_phone,
                        "device_id" => $device_id
                    )
                );
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Error: " . $sql_insert . "<br>" . $conn->error
                );
            }
        } else {
            $response = array(
                "status" => "error",
                "message" => "Mobile number already exists. Skipping insert."
            );
        }
    } else {
        $response = array(
            "status" => "error",
            "message" => "Error: " . $sql_check . "<br>" . $conn->error
        );
    }

    // Close the database connection
    $conn->close();

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
