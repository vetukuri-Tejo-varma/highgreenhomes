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
    $device_id = sanitize($_POST['device_id']);

    // Prepare the SQL statement to check if the user already exists
    $sql_check = "SELECT COUNT(*) as count FROM highgreen_users WHERE user_email = '$user_email'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $count = $row['count'];

        if ($count === '0') {
            // If the user does not exist, perform the insert
            $sql_insert = "INSERT INTO highgreen_users (user_name, user_email, device_id) 
                           VALUES ('$user_name', '$user_email', '$device_id')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "Data inserted successfully.";
            } else {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            // If the user already exists, perform the update
            $sql_update = "UPDATE highgreen_users SET user_name = '$user_name', device_id = '$device_id' WHERE user_email = '$user_email'";

            if ($conn->query($sql_update) === TRUE) {
                echo "Data updated successfully.";
            } else {
                echo "Error: " . $sql_update . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql_check . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
