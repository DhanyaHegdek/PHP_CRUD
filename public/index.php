<?php

//  CORS headers (must be before output)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");

//  Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

//  Composer autoload
require __DIR__ . '/../vendor/autoload.php';

//  Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

//  Load routes
require __DIR__ . '/../routes/web.php';

//  Get request URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//  Remove base path (/PHP/public)
$basePath = '/PHP/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

//  Normalize URI
$uri = rtrim($uri, '/');
if ($uri === '') {
    $uri = '/';
}

//  Get HTTP method
$method = $_SERVER['REQUEST_METHOD'];

//  Debug (uncomment if needed)
// echo "URI: " . $uri; exit;

//  Dispatch route
route($uri, $method);