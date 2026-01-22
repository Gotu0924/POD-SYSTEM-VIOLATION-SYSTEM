<?php
include '../includes/db_connection.php';

$id = $_GET['id'];

$sql = "SELECT * FROM t_students WHERE s_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo json_encode($student);
} else {
    echo json_encode(['error' => 'Student not found']);
}

$stmt->close();
$conn->close();
?>
