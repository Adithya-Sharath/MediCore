<?php
header('Content-Type: application/json');

$vars = [
    'MYSQL_HOST'     => getenv('MYSQL_HOST'),
    'MYSQL_USER'     => getenv('MYSQL_USER'),
    'MYSQL_PASSWORD' => getenv('MYSQL_PASSWORD') ? '***set***' : 'NOT SET',
    'MYSQL_DATABASE' => getenv('MYSQL_DATABASE'),
    'MYSQL_PORT'     => getenv('MYSQL_PORT'),
    'MYSQLHOST'      => getenv('MYSQLHOST'),
    'MYSQLUSER'      => getenv('MYSQLUSER'),
    'MYSQLDATABASE'  => getenv('MYSQLDATABASE'),
    'MYSQLPORT'      => getenv('MYSQLPORT'),
];

echo json_encode($vars);
