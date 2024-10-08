<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Images</title>
    <!-- Include necessary libraries -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-success">Upload Images</h2>
                </div>
                <div class="card-body">
                    <!-- Form for image upload -->
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country-dropdown" name="category">
                                <option value="">Select Construction Type</option>
                                <?php
                                require_once "config.php";
                                $result = mysqli_query($conn,"SELECT * FROM construction_type");
                                while($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row["category"];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state">Sub-Category</label>
                            <select class="form-control" id="state-dropdown" name="sub_category_1"></select>
                        </div>
                        <div class="form-group">
                            <label for="city">Sub-Category 2</label>
                            <select class="form-control" id="city-dropdown" name="sub_category_2"></select>
                        </div>
                        <div class="form-group">
                            Select Image File to Upload:
                            <input type="file" name="file" id="fileInput">
                        </div>
                        <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                        <!-- Container to display status messages -->
                        <div id="statusMsg"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
   $(document).ready(function() {
    // Handle country dropdown change
    $('#country-dropdown').on('change', function() {
        var category_id = this.value;
        $.ajax({
            url: "get_sub_categories.php",
            type: "POST",
            data: { category_id: category_id },
            cache: false,
            success: function(result) {
                $("#state-dropdown").html(result);
                $('#city-dropdown').html('<option value="">Select Sub-Category-1 First</option>');
            }
        });
    });

    // Handle sub-category dropdown change
    $('#state-dropdown').on('change', function() {
        var state_id = this.value;
        $.ajax({
            url: "get_sub_categories2.php",
            type: "POST",
            data: { sub_category_id: state_id },
            cache: false,
            success: function(result) {
                $("#city-dropdown").html(result);
            }
        });
    });

    // Handle form submission
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var fileInput = $('#fileInput')[0].files[0]; // Get the selected file
        if (!fileInput) {
            $('#statusMsg').html('<div class="alert alert-danger">Please select a file to upload.</div>');
            return; // Exit if no file is selected
        }

        var formData = new FormData(this);
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#statusMsg').html('<div class="alert alert-info">' + response + '</div>'); // Display the server response
            },
            error: function() {
                $('#statusMsg').html('<div class="alert alert-danger">There was an error uploading your file.</div>');
            }
        });
    });
});

    </script>
</body>
</html>
