<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST method required']);
    exit;
}

$patient_id = isset($_POST['patient_id']) ? (int)$_POST['patient_id'] : 0;
$doctor_id  = isset($_POST['doctor_id'])  ? (int)$_POST['doctor_id']  : 0;
$date       = trim($_POST['date'] ?? '');
$time       = trim($_POST['time'] ?? '');

if (!$patient_id || !$doctor_id || $date === '' || $time === '') {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid date format (expected YYYY-MM-DD)']);
    exit;
}

if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid time format']);
    exit;
}

// Pad seconds if missing
if (strlen($time) === 5) {
    $time .= ':00';
}

$stmt = $conn->prepare("CALL BookAppointment(?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Appointment booked and bill auto-generated']);
} else {
    http_response_code(500);
    echo json_encode(['error' => $stmt->error]);
}

$stmt->close();
$conn->close();
