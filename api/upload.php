<?php
require_once "config.php"; // Ensure the database connection is included

// Get the selected sub-category 2 from the form
$sub_category_2 = isset($_POST['sub_category_2']) ? $_POST['sub_category_2'] : '';
$category_name  = isset($_POST['category_name']) ? $_POST['category_name'] : '';
$sub_category_3 = isset($_POST['sub_category_3']) ? $_POST['sub_category_3'] : '';
$sub_category_4 = isset($_POST['sub_category_4']) ? $_POST['sub_category_4'] : '';

// Check if a file is selected
if (!empty($_FILES["file"]["name"])) {
    // Get file details
    $fileName = basename($_FILES["file"]["name"]);
    $targetDir = "uploads/";
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only specific file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        // Attempt to upload the file to the server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Prepare an SQL statement to insert file details into the database
            $insert = "INSERT INTO images (file_name, uploaded_on, category, sub_category_1, sub_category_2, category_name, sub_category3, sub_category4) 
                       VALUES ('$fileName', NOW(), '$category', '$sub_category_1', '$sub_category_2', '$category_name', '$sub_category_3', '$sub_category_4')";
            // Execute the query and check if it was successful
            if ($conn->query($insert) === TRUE) {
                $statusMsg = "The file " . $fileName . " has been uploaded successfully. File path: " . $targetFilePath;
            } else {
                $statusMsg = "File upload failed, please try again. Error: " . $conn->error;
            }
        } else {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    } else {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

// Output the status message
echo $statusMsg;
?>