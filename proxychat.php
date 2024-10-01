<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$url = 'https://www.highgreenhomes.com/api/store_chat.php';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>