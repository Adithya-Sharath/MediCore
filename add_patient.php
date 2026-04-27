<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);

require_once 'db.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (empty($data)) {
    $data = $_POST;
}

$name    = $data['name']    ?? null;
$age     = $data['age']     ?? null;
$gender  = $data['gender']  ?? null;
$phone   = $data['phone']   ?? null;
$address = $data['address'] ?? null;

if (!$name || !$age || !$gender || !$phone) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

$sql = "INSERT INTO Patient (name, age, gender, phone, address) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sisss', $name, $age, $gender, $phone, $address);

if (mysqli_stmt_execute($stmt)) {
    $new_id = mysqli_insert_id($conn);
    echo json_encode([
        'success' => true,
        'patient_id' => $new_id,
        'name' => $name
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
