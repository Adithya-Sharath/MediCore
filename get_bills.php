<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);

require_once 'db.php';

$sql = "SELECT b.bill_id, b.appointment_id,
               p.name AS patient_name, b.total_amount
        FROM Bill b
        JOIN Appointment a ON b.appointment_id = a.appointment_id
        JOIN Patient p ON a.patient_id = p.patient_id
        ORDER BY b.bill_id DESC";

$result = mysqli_query($conn, $sql);
$bills = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bills[] = $row;
}
echo json_encode($bills);
?>
