<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Showcase</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-container {
            margin-bottom: 15px;
        }
        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4 text-center">Image Showcase</h1>
        <div class="row" id="image-gallery">
            <?php
            // Include the PHP script to fetch images
            include 'fetch_images.php';

            // Loop through the images and generate HTML
            foreach ($images as $image) {
                echo '<div class="col-lg-3 col-md-4 col-sm-6 image-container">';
                echo '<img src="' . $image . '" alt="Image">';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>