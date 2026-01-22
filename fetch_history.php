<?php
include 'includes/db_connection.php';
session_start();

$loggedInUser = $_SESSION['id'] ?? '';

if (empty($loggedInUser)) {
    echo json_encode([]);
    exit;
}

// Fetch only records from t_logs where a_username matches the logged-in user
$sql = "SELECT * 
        FROM history_staff 
        WHERE a_username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUser);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
