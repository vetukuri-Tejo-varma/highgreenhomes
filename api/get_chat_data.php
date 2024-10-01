<?php
require_once "config.php"; // Include the database configuration file

header('Content-Type: application/json');

$response = array('status' => 'error', 'chatData' => array());

$sql = "SELECT * FROM chat_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $chatData = array();
    while ($row = $result->fetch_assoc()) {
        $chatData[] = $row;
    }
    $response['status'] = 'success';
    $response['chatData'] = $chatData;
} else {
    $response['message'] = 'No chat data found';
}

$conn->close();

echo json_encode($response);
?>