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
        "SELECT b.bill_id,
                b.total_amount,
                p.name AS patient_name,
                d.name AS doctor_name,
                a.appointment_date,
                a.appointment_time,
                a.status
         FROM Bill b
         JOIN Appointment a ON b.appointment_id = a.appointment_id
         JOIN Patient     p ON a.patient_id     = p.patient_id
         JOIN Doctor      d ON a.doctor_id      = d.doctor_id
         ORDER BY b.bill_id DESC"
    );

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $conn->close();
    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
