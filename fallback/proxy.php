<?php
// Get the requested path
$path = isset($_GET['file']) ? $_GET['file'] : '';

// Validate the path to avoid abuse
$allowed_ext = ['jpg','jpeg','png','gif','webp','svg','js','css','woff','woff2','ttf','eot','mp4','webm','ogg'];
$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed_ext)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

// Try to fetch the file from the live site
$remote_url = 'https://koalla.gr/' . ltrim($path, '/');

// Get and serve the content
$ch = curl_init($remote_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$data = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($http_code === 200) {
    header("Content-Type: $content_type");
    echo $data;
} else {
    header("HTTP/1.1 404 Not Found");
}
