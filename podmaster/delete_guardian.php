<?php
include 'db_connection.php';

$g_ID = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM t_guardians WHERE g_ID = ?");
$stmt->bind_param("i", $g_ID);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Guardian deleted successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete guardian."]);
}

$stmt->close();
$conn->close();
?>