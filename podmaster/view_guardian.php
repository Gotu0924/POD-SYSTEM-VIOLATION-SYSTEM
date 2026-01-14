<?php
include 'db_connection.php';

$g_ID = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM t_guardians WHERE g_ID = ?");
$stmt->bind_param("i", $g_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $guardian = $result->fetch_assoc();
    echo json_encode($guardian);
} else {
    echo json_encode(["status" => "error", "message" => "Guardian not found."]);
}

$stmt->close();
$conn->close();
?>