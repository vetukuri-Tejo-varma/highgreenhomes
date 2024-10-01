<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Showcase</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .category-menu {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .category-menu .category-item {
            margin: 5px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .category-menu .category-item:hover {
            background-color: #0056b3;
        }
        .image-container {
            margin-bottom: 30px;
        }
        .image-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            border-radius: 5px;
        }
        .card-body {
            text-align: center;
        }
        .no-images {
            text-align: center;
            margin-top: 20px;
        }
        .fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .fab:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4 text-center">Image Showcase</h1>
        <div class="category-menu">
            <?php
            // Hardcoded list of categories
            $categories = [
                "Interior Design", "Residential", "Living", "Foyer Unit", "Popdesign", "Wooden pop", "Gypsum pop", "Door", 
                "Wooden carving doors", "Brass casting door plate", "Window", "Flooring", "Stone Flooring", "Wooden Flooring", 
                "Carpet Flooring", "Pooja Unit", "Sofa", "Rexine Sofa (Normal)", "Wooden Sofa", "Tifai", "Tv unit", "Partition", 
                "Airocon Partition", "Wooden/Plywood Partition", "Aluminium Partition", "Chairs", "Rexine Chairs", "Wooden Chairs", 
                "Plastic Chairs", "Curtains", "Cloth", "Zebra blends", "Roman", "Designer", "Carpet", "Lighting", "Zoomer", 
                "Wall Lights", "Pop Pannelling Lights", "Balcony Lights", "Water Bubble Panel", "Glass pillar", "Bed Room", 
                "Master Bed Room", "Aristo Wardrobe", "Cot", "Cot Headrest", "Study Unit", "Mattress", "Pillows", "Bed Spread", 
                "Rug/Quilt", "Kids Bed Room", "Kitchen", "Modular Kitchen", "Crockery Unit", "Dining", "Kitchen Chimney", 
                "Kitchen Hob", "Kitchen Sink", "Breakfast Counter", "Bathroom", "Mirror", "Glass Partition", "Bath Tub", "Shower", 
                "Commode", "Hand Wash Unit", "Commercial", "Hotel", "Hospital", "School", "Office", "Exterior Design", "Cladding", 
                "Stone & Tiles Cladding", "Wooden & Bricks Cladding", "Acp Cladding", "High Pressure Laminate", "Metal & S Cladding", 
                "Texture Cladding", "Gypsum Board Cladding", "Acp Work", "Stair Case", "Gates", "Water Fountain", "Grills", "Ss Grill", 
                "MS Grill", "Swimming Pool", "Railing", "Ss & MS Railing", "Brass Railing", "Construction", "Residential", "Single Door", 
                "Duplex", "Triplex", "Multistory Buildings", "Commercial", "Hotel", "Hospital", "Office", "School", "Eco-Friendly", 
                "Balcony gardening", "Living Door"
            ];

            // Function to generate category items
            function generateCategoryItems($categories) {
                foreach ($categories as $category) {
                    echo '<div class="category-item" data-category="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</div>';
                }
            }

            // Generate category items
            generateCategoryItems($categories);
            ?>
        </div>
        <div class="row" id="image-gallery">
            <!-- Images will be loaded here -->
        </div>
    </div>

    <div class="fab" id="fab">
        <i class="fas fa-plus"></i>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var $grid = $('#image-gallery').masonry({
                itemSelector: '.image-container',
                columnWidth: '.image-container',
                percentPosition: true
            });

            $('.category-item').click(function() {
                var category = $(this).data('category');
                fetchImages(category);
            });

            function fetchImages(category) {
                $.ajax({
                    url: 'proxy.php',
                    method: 'POST',
                    data: { category_name: category },
                    success: function(response) {
                        console.log(response); // Log the response for debugging
                        if (response.status === 'success') {
                            var images = response.images;
                            var imageGallery = $('#image-gallery');
                            imageGallery.empty();
                            var loadedImages = 0;
                            images.forEach(function(image) {
                                var imageContainer = $('<div class="col-lg-3 col-md-4 col-sm-6 image-container"></div>');
                                var card = $('<div class="card"></div>');
                                var imgLink = $('<a>').attr('href', image).attr('data-lightbox', 'gallery');
                                var img = $('<img>').attr('src', image).attr('alt', 'Image').addClass('card-img-top');
                                var cardBody = $('<div class="card-body"></div>');
                                var cardText = $('<p class="card-text"></p>').text(category);
                                cardBody.append(cardText);
                                imgLink.append(img);
                                card.append(imgLink).append(cardBody);
                                imageContainer.append(card);
                                imageGallery.append(imageContainer);

                                img.on('load', function() {
                                    loadedImages++;
                                    if (loadedImages === images.length) {
                                        $grid.masonry('layout');
                                    }
                                });
                            });
                        } else {
                            $('#image-gallery').html('<p class="no-images">No images found for the selected category.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            $('#fab').click(function() {
                alert('FAB clicked!');
            });
        });
    </script>
</body>
</html>