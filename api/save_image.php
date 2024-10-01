<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login page or show an error message
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop further execution
}
?>
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
                                $result = mysqli_query($conn, "SELECT * FROM construction_type");
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row["category"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state">Sub-Category 1</label>
                            <select class="form-control" id="state-dropdown" name="sub_category_1"></select>
                        </div>
                        <div class="form-group">
                            <label for="city">Sub-Category 2</label>
                            <select class="form-control" id="city-dropdown" name="sub_category_2"></select>
                        </div>
                        <div class="form-group">
                            <label for="sub">Sub-Category 3</label>
                            <select class="form-control" id="sub_category_dropdown" name="sub_category_3"></select>
                        </div>
                        <div class="form-group">
                            <label for="sub">Sub-Category 4</label>
                            <select class="form-control" id="sub_category_dropdown1" name="sub_category_4"></select>
                        </div>
                        <div class="form-group">
                            Select Image File to Upload:
                            <input type="file" name="files[]" id="fileInput" multiple>
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
            console.log('Selected Category ID:', category_id); // Debugging
            $.ajax({
                url: "get_sub_categories.php",
                type: "POST",
                data: { category_id: category_id },
                cache: false,
                success: function(result) {
                    console.log('Sub-Category 1 Data:', result); // Debugging
                    $("#state-dropdown").html(result);
                    $('#city-dropdown').html('<option value="">Select Sub-Category 2</option>');
                    $('#sub_category_dropdown').html('<option value="">Select Sub-Category 3</option>');
                    $('#sub_category_dropdown1').html('<option value="">Select Sub-Category 4</option>');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Debugging
                }
            });
        });

        // Handle state-dropdown change
        $('#state-dropdown').on('change', function() {
            var state_id = this.value;
            console.log('Selected Sub-Category 1 ID:', state_id); // Debugging
            $.ajax({
                url: "get_sub_categories2.php",
                type: "POST",
                data: { category_id: state_id },
                cache: false,
                success: function(result) {
                    console.log('Sub-Category 2 Data:', result); // Debugging
                    $("#city-dropdown").html(result);
                    $('#sub_category_dropdown').html('<option value="">Select Sub-Category 3</option>');
                    $('#sub_category_dropdown1').html('<option value="">Select Sub-Category 4</option>');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Debugging
                }
            });
        });

        // Handle city-dropdown change
        $('#city-dropdown').on('change', function() {
            var city_id = this.value;
            console.log('Selected Sub-Category 2 ID:', city_id); // Debugging
            $.ajax({
                url: "get_sub_categories3.php",
                type: "POST",
                data: { category_id: city_id },
                cache: false,
                success: function(result) {
                    console.log('Sub-Category 3 Data:', result); // Debugging
                    $("#sub_category_dropdown").html(result);
                    $('#sub_category_dropdown1').html('<option value="">Select Sub-Category 4</option>');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Debugging
                }
            });
        });

        // Handle sub_category_dropdown change
        $('#sub_category_dropdown').on('change', function() {
            var sub_category_id = this.value;
            console.log('Selected Sub-Category 3 ID:', sub_category_id); // Debugging
            $.ajax({
                url: "get_sub_categories4.php",
                type: "POST",
                data: { category_id: sub_category_id },
                cache: false,
                success: function(result) {
                    console.log('Sub-Category 4 Data:', result); // Debugging
                    $("#sub_category_dropdown1").html(result);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Debugging
                }
            });
        });

        // Handle form submission
        $('#uploadForm').off('submit').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $('#uploadForm :input[type=submit]').prop('disabled', true); // Disable submit button

            var files = $('#fileInput')[0].files; // Get the selected files
            if (files.length === 0) {
                $('#statusMsg').html('<div class="alert alert-danger">Please select files to upload.</div>');
                $('#uploadForm :input[type=submit]').prop('disabled', false); // Re-enable submit button
                return; // Exit if no files are selected
            }

            var formData = new FormData(this);

            // Get the selected category names
            var categoryName = $('#country-dropdown option:selected').text(); // Get the selected category name
            var subCategory1 = $('#state-dropdown option:selected').text(); // Get the selected sub-category 1 name
            var subCategory2 = $('#city-dropdown option:selected').text(); // Get the selected sub-category 2 name
            var subCategory3 = $('#sub_category_dropdown option:selected').text(); // Get the selected sub-category 3 name
            var subCategory4 = $('#sub_category_dropdown1 option:selected').text(); // Get the selected sub-category 4 name
            var combinedCategoryName = categoryName + ',' + subCategory1 + ',' + subCategory2 + ',' + subCategory3 + ',' + subCategory4; // Combine the names separated by commas
            formData.append('category_name', combinedCategoryName); // Append the combined category name to the form data

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#statusMsg').html('<div class="alert alert-info">' + response + '</div>'); // Display the server response
                    $('#uploadForm :input[type=submit]').prop('disabled', false); // Re-enable submit button
                },
                error: function() {
                    $('#statusMsg').html('<div class="alert alert-danger">There was an error uploading your files.</div>');
                    $('#uploadForm :input[type=submit]').prop('disabled', false); // Re-enable submit button
                }
            });
        });
    });
    </script>
</body>
</html>