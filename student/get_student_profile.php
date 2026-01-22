<?php
// ../student/get_student_profile.php
session_start();
include '../includes/db_connection.php'; // << make sure this connects to your DB

if (!isset($_SESSION['student_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$studentId = $_SESSION['student_id'];

$sql = "SELECT *
        FROM t_students 
        WHERE st_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Student not found']);
}
?>
