<?php
require "config.php";
$category_id = $_POST["category_id"];
$result = mysqli_query($conn,"SELECT * FROM sub_category_4 where sub_category_id3 = $category_id");

$response = '<option value="" disabled selected>Select Sub Category 3</option>';

while($row = mysqli_fetch_array($result)) {
    $response .= '<option value=' . $row["id"] . '>'.  $row["name"] .'</option>';
}
echo $response;
?>