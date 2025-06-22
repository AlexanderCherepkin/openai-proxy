<?php
// Простой PHP-прокси для пересылки запросов на указанный URL

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$targetUrl = $_GET['url'] ?? null;

if (!$targetUrl) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'url' parameter"]);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    http_response_code(502);
    echo json_encode(["error" => "Curl error: $error"]);
} else {
    http_response_code($httpcode);
    echo $response;
}
?>
