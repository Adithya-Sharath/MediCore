<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 0);
error_reporting(0);

try {
    require 'db.php';

    $result = $conn->query(
        "SELECT d.doctor_id, d.name, d.specialization, d.phone,
                dep.department_name
         FROM Doctor d
         JOIN Department dep ON d.department_id = dep.department_id
         ORDER BY d.doctor_id"
    );

    if (!$result) {
        throw new Exception($conn->error);
    }

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }

    $conn->close();
    echo json_encode(['success' => true, 'doctors' => $doctors]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
