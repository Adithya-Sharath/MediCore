<?php
$host = getenv('MYSQLHOST');         // mysql.railway.internal
$user = getenv('MYSQLUSER');         // root
$pass = getenv('MYSQLPASSWORD');     // exists but hidden
$db   = getenv('MYSQL_DATABASE');    // railway
$port = getenv('MYSQLPORT') ?: 3306; // 3306

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect($conn, $host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed: ' . mysqli_connect_error()]);
    exit;
}
