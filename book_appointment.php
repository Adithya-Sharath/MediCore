<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);

require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$patient_id = $data['patient_id'];
$doctor_id  = $data['doctor_id'];
$date       = $data['date'];
$time       = $data['time'];

$sql = "INSERT INTO Appointment (patient_id, doctor_id, appointment_date, appointment_time, status)
        VALUES (?, ?, ?, ?, 'Scheduled')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iiss', $patient_id, $doctor_id, $date, $time);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
