<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);

require_once 'db.php';

$sql = "SELECT a.appointment_id, p.name AS patient_name,
               d.name AS doctor_name, a.appointment_date,
               a.appointment_time, a.status
        FROM Appointment a
        JOIN Patient p ON a.patient_id = p.patient_id
        JOIN Doctor d ON a.doctor_id = d.doctor_id
        ORDER BY a.appointment_id DESC";

$result = mysqli_query($conn, $sql);
$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}
echo json_encode($appointments);
?>
