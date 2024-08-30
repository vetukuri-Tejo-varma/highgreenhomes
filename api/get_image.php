<?php
require "config.php";

// Assume you're getting POST data
$category_name = $_POST['category_name'];

$query = "SELECT * FROM images WHERE 1=1";

if ($category_name) {
    $query .= " AND category_name LIKE '%$category_name%'";
}

$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

$response = array();
$response['status'] = 'success';
$response['images'] = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        array_push($response['images'], "https://highgreenhomes.com/api/uploads/" . $row['file_name']);
    }
} else {
    $response['status'] = 'no records found';
}

// Encode and return the response
echo json_encode($response);
?>
