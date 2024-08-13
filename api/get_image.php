<?php
require "config.php";

$value1 = $_GET['category'];
$value2 = $_GET['sub_category_1'];
$value3 = $_GET['sub_category_2'];

$query = "SELECT file_name FROM images WHERE 1 ";
if($value1){
    $query .= " And category = '$value1'";
}
if($value2){
    $query .= " And sub_category_1 = '$value2' ";
}

if($value3){
    $query .= " And sub_category_2 = '$value2'";
}

$result = mysqli_query($conn, $query);

$response = array();

while($row = mysqli_fetch_array($result)) {
    array_push($response, "https://highgreenhomes.com/api/uploads/" . $row['file_name']);
}
echo json_encode($response);
?>
