<?php
// db_config.php

// Database settings
$host = 'localhost'; // Change this to your database host
$username = 'u641855235_highgreen'; // Change this to your database username
$password = 'Highgreen@123'; // Change this to your database password
$db_name = 'u641855235_highgreen_home'; // Change this to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
