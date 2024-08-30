<?php
require_once "config.php"; // Ensure the database connection is included

header('Content-Type: application/json');

$response = array('status' => 'success', 'categories' => array());

// Fetch main categories
$mainCategoriesQuery = "SELECT * FROM construction_type";
$mainCategoriesResult = mysqli_query($conn, $mainCategoriesQuery);

while ($mainCategory = mysqli_fetch_assoc($mainCategoriesResult)) {
    $categoryId = $mainCategory['id'];
    $categoryName = $mainCategory['category'];

    // Fetch sub-categories for each main category
    $subCategories1Query = "SELECT * FROM sub_category_1 WHERE category_id = $categoryId";
    $subCategories1Result = mysqli_query($conn, $subCategories1Query);

    $subCategories1 = array();
    while ($subCategory1 = mysqli_fetch_assoc($subCategories1Result)) {
        $subCategoryId1 = $subCategory1['id'];
        $subCategoryName1 = $subCategory1['name'];

        // Fetch sub-categories for each sub-category 1
        $subCategories2Query = "SELECT * FROM sub_category_2 WHERE sub_category_id = $subCategoryId1";
        $subCategories2Result = mysqli_query($conn, $subCategories2Query);

        $subCategories2 = array();
        while ($subCategory2 = mysqli_fetch_assoc($subCategories2Result)) {
            $subCategoryId2 = $subCategory2['id'];
            $subCategoryName2 = $subCategory2['name'];

            // Fetch sub-categories for each sub-category 2
            $subCategories3Query = "SELECT * FROM sub_category_3 WHERE sub_category_id2 = $subCategoryId2";
            $subCategories3Result = mysqli_query($conn, $subCategories3Query);

            $subCategories3 = array();
            while ($subCategory3 = mysqli_fetch_assoc($subCategories3Result)) {
                $subCategoryId3 = $subCategory3['id'];
                $subCategoryName3 = $subCategory3['name'];

                // Fetch sub-categories for each sub-category 3
                $subCategories4Query = "SELECT * FROM sub_category_4 WHERE sub_category_id3 = $subCategoryId3";
                $subCategories4Result = mysqli_query($conn, $subCategories4Query);

                $subCategories4 = array();
                while ($subCategory4 = mysqli_fetch_assoc($subCategories4Result)) {
                    $subCategories4[] = $subCategory4['name'];
                }

                $subCategories3[] = array(
                    $subCategoryName3 => $subCategories4
                );
            }

            $subCategories2[] = array(
                $subCategoryName2 => $subCategories3
            );
        }

        $subCategories1[$subCategoryName1] = $subCategories2;
    }

    $response['categories'][$categoryName] = $subCategories1;
}

echo json_encode($response);
?>