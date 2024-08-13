<?php
// Include the database configuration file to establish a connection
include 'config.php';

$statusMsg = ''; // Variable to hold status messages

// File upload path
$targetDir = "uploads/"; // Directory where files will be uploaded
$fileName = basename($_FILES["file"]["name"]); // Get the file name
$targetFilePath = $targetDir . $fileName; // Full path where the file will be stored
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); // Get the file extension
$category = $_POST['category']; // Get the selected category from the form
$sub_category_1 = $_POST['sub_category_1']; // Get the selected sub-category 1 from the form

// Check if a file is selected
if (!empty($_FILES["file"]["name"])) {
    // Allow only specific file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        // Attempt to upload the file to the server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Prepare an SQL statement to insert file details into the database
            $insert = "INSERT INTO images (file_name, uploaded_on, category, sub_category_1) 
                       VALUES ('$fileName', NOW(), $category, $sub_category_1)";
            // Execute the query and check if it was successful
            if ($conn->query($insert) === TRUE) {
                $statusMsg = "The file " . $fileName . " has been uploaded successfully. File path: " . $targetFilePath;
            } else {
                $statusMsg = "File upload failed, please try again.";
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
