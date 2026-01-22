<?php
include '../includes/db_connection.php'; // Ensure this file connects to your database

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $stmt = $conn->prepare("SELECT * FROM t_students WHERE st_ID = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo ($result->num_rows > 0) ? "exists" : "available";

    $stmt->close();
    $conn->close();
}
?>
