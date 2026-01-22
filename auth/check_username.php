<?php
include '../includes/db_connection.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username']);
$id = intval($data['id']);

if (!$username) {
    echo json_encode(['exists' => false]);
    exit;
}

// Check if username exists for other admins
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM t_admins WHERE a_username = ? AND a_ID != ?");
$stmt->bind_param("si", $username, $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode(['exists' => $result['count'] > 0]);
?>
