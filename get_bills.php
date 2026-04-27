<?php
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
    echo json_encode(['error' => $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
