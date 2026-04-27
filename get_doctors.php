<?php
require 'db.php';

$result = $conn->query(
    "SELECT d.doctor_id, d.name, d.specialization, d.phone,
            dep.department_name
     FROM Doctor d
     JOIN Department dep ON d.department_id = dep.department_id
     ORDER BY d.doctor_id"
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
