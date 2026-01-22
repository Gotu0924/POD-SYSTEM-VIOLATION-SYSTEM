<?php
header('Content-Type: application/json');
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['i_ID'])) {
    $id = intval($_POST['i_ID']);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid sanction ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM issues_archive WHERE i_ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Sanction deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting sanction: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
