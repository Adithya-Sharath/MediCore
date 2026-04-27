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
        "SELECT a.appointment_id,
                a.appointment_date,
                a.appointment_time,
                a.status,
                p.name  AS patient_name,
                d.name  AS doctor_name,
                dep.department_name
         FROM Appointment a
         JOIN Patient    p   ON a.patient_id    = p.patient_id
         JOIN Doctor     d   ON a.doctor_id     = d.doctor_id
         JOIN Department dep ON d.department_id = dep.department_id
         ORDER BY a.appointment_date DESC, a.appointment_time DESC"
    );

    if (!$result) {
        throw new Exception($conn->error);
    }

    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }

    $conn->close();
    echo json_encode(['success' => true, 'appointments' => $appointments]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
