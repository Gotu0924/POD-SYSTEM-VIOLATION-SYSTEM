<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the Content-Type header to JSON for API responses
header('Content-Type: application/json');

// Get the last seen sanction ID from the request (default to 0)
$lastSanctionId = isset($_GET['lastSanctionId']) ? intval($_GET['lastSanctionId']) : 0;

// Fetch all sanctions with i_ID greater than lastSanctionId
$query = "SELECT * FROM t_logs WHERE i_ID > ? ORDER BY i_ID ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $lastSanctionId);
$stmt->execute();
$result = $stmt->get_result();

$sanctions = [];
while ($row = $result->fetch_assoc()) {
    $sanctions[] = $row;
}

if (count($sanctions) > 0) {
    echo json_encode(['success' => true, 'sanctions' => $sanctions]);
} else {
    echo json_encode(['success' => false, 'sanctions' => []]);
}

$stmt->close();
$conn->close();
?>
