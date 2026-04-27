<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
ini_set('display_errors', 0);

require_once 'db.php';

// Read JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Fallback to POST if JSON empty
if (empty($data)) {
    $data = $_POST;
}

$patient_id = isset($data['patient_id']) ? (int)$data['patient_id'] : null;
$doctor_id  = isset($data['doctor_id'])  ? (int)$data['doctor_id']  : null;
$date       = isset($data['date'])       ? $data['date']            : null;
$time       = isset($data['time'])       ? $data['time']            : null;

if (!$patient_id || !$doctor_id || !$date || !$time) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Missing fields',
        'received' => $data
    ]);
    exit;
}

$sql = "INSERT INTO Appointment
        (patient_id, doctor_id, appointment_date, appointment_time, status)
        VALUES (?, ?, ?, ?, 'Scheduled')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iiss', $patient_id, $doctor_id, $date, $time);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
