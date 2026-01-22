<?php
// delete_../admin/admin.php
header('Content-Type: application/json');
require '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'])) {
    $adminID = intval($_POST['admin_id']);

    if ($adminID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid admin ID.']);
        exit;
    }

    $sql = "DELETE FROM admins_archive WHERE a_ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $adminID);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Admin deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Admin not found or already deleted.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting admin: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
