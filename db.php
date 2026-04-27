<?php
ini_set('display_errors', 0);
error_reporting(0);

$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$db   = getenv('MYSQL_DATABASE');
$port = getenv('MYSQL_PORT') ?: 3306;

$conn = new mysqli($host, $user, $pass, $db, (int)$port);
if ($conn->connect_error) {
    throw new Exception('DB connection failed: ' . $conn->connect_error);
}
