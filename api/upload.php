<?php
require_once "config.php"; // Ensure the database connection is included

// Get the selected sub-category 2 from the form
$sub_category_1 = isset($_POST['sub_category_1']) ? $_POST['sub_category_1'] : '';
$sub_category_2 = isset($_POST['sub_category_2']) ? $_POST['sub_category_2'] : '';
$category_name  = isset($_POST['category_name']) ? $_POST['category_name'] : '';
$sub_category_3 = isset($_POST['sub_category_3']) ? $_POST['sub_category_3'] : '';
$sub_category_4 = isset($_POST['sub_category_4']) ? $_POST['sub_category_4'] : '';

// Check if files are selected
if (!empty($_FILES["files"]["name"][0])) {
    $targetDir = "uploads/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    $statusMsg = '';

    foreach ($_FILES['files']['name'] as $key => $val) {
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only specific file formats
        if (in_array($fileType, $allowTypes)) {
            // Attempt to upload the file to the server
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                // Prepare an SQL statement to insert file details into the database
                $insert = "INSERT INTO images (file_name, uploaded_on, category, sub_category_1, sub_category_2, category_name, sub_category3, sub_category4) 
                           VALUES ('$fileName', NOW(), '$category', '$sub_category_1', '$sub_category_2', '$category_name', '$sub_category_3', '$sub_category_4')";
                // Execute the query and check if it was successful
                if ($conn->query($insert) === TRUE) {
                    $statusMsg .= "The file " . $fileName . " has been uploaded successfully. File path: " . $targetFilePath . "<br>";
                } else {
                    $statusMsg .= "File upload failed for " . $fileName . ", please try again. Error: " . $conn->error . "<br>";
                }
            } else {
                $statusMsg .= "Sorry, there was an error uploading your file " . $fileName . ".<br>";
            }
        } else {
            $statusMsg .= 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.<br>';
        }
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

echo $statusMsg;
?>