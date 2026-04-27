<?php
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
     JOIN Patient    p   ON a.patient_id  = p.patient_id
     JOIN Doctor     d   ON a.doctor_id   = d.doctor_id
     JOIN Department dep ON d.department_id = dep.department_id
     ORDER BY a.appointment_date DESC, a.appointment_time DESC"
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
