<?php
require 'db.php';

$result = $conn->query(
    "SELECT patient_id, name, age, gender, phone, address
     FROM Patient
     ORDER BY patient_id"
);

if (!$result) {
    echo json_encode(['error' => $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
