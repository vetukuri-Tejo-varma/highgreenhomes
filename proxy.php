<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $url = 'https://www.highgreenhomes.com/api/get_image.php';
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query(['category_name' => $category_name]),
        ],
    ];
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo $response;
}
?>