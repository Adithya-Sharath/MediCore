<?php
$host = getenv('MYSQLHOST');         // mysql.railway.internal
$user = getenv('MYSQLUSER');         // root
$pass = getenv('MYSQLPASSWORD');     // exists but hidden
$db   = getenv('MYSQL_DATABASE');    // railway
$port = getenv('MYSQLPORT') ?: 3306; // 3306

$conn = mysqli_connect($host, $user, $pass, $db, (int)$port);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed: ' . mysqli_connect_error()]);
    exit;
}
