<?php
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$db   = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT') ?: 3306;

$conn = new mysqli($host, $user, $pass, $db, (int)$port);
if ($conn->connect_error) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
