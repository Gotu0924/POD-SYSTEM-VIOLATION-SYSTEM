<?php
header('Content-Type: application/json');
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['g_ID'])) {
    $id = intval($_POST['g_ID']);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid guardian ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM guardian_archive WHERE g_ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Guardian deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting guardian: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
