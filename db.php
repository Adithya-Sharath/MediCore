<?php
$host   = getenv('MYSQL_HOST')     ?: getenv('DB_HOST')     ?: 'localhost';
$dbname = getenv('MYSQL_DATABASE') ?: getenv('DB_NAME')     ?: 'hospital_db';
$user   = getenv('MYSQL_USER')     ?: getenv('DB_USER')     ?: 'root';
$pass   = getenv('MYSQL_PASSWORD') ?: getenv('DB_PASSWORD') ?: '';

$conn = new mysqli($host, $user, $pass, $dbname);
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
