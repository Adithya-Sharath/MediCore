<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 0);
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'POST method required']);
        exit;
    }

    // Accept both JSON body and form-encoded body
    $raw  = file_get_contents('php://input');
    $body = json_decode($raw, true);
    if (!is_array($body)) {
        $body = $_POST;
    }

    $patient_id = isset($body['patient_id']) ? (int)$body['patient_id'] : 0;
    $doctor_id  = isset($body['doctor_id'])  ? (int)$body['doctor_id']  : 0;
    $date       = trim($body['date'] ?? '');
    $time       = trim($body['time'] ?? '');

    if (!$patient_id || !$doctor_id || $date === '' || $time === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'All fields are required']);
        exit;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid date format (expected YYYY-MM-DD)']);
        exit;
    }

    if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid time format (expected HH:MM)']);
        exit;
    }

    if (strlen($time) === 5) {
        $time .= ':00';
    }

    require 'db.php';

    $stmt = $conn->prepare("CALL BookAppointment(?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
