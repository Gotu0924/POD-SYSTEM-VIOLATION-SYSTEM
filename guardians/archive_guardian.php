<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../includes/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardian_id'])) {
    $guardianId = intval($_POST['guardian_id']);

    // Step 1: Fetch the guardian details
    $stmt = $conn->prepare("SELECT * FROM t_guardians WHERE g_ID = ?");
    $stmt->bind_param("i", $guardianId);
    $stmt->execute();
    $result = $stmt->get_result();
    $guardian = $result->fetch_assoc();

    if (!$guardian) {
        echo json_encode(['success' => false, 'error' => 'Guardian not found']);
        exit;
    }

    // Step 2: Check if already archived
    $check = $conn->prepare("SELECT * FROM guardian_archive WHERE g_ID = ?");
    $check->bind_param("i", $guardianId);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Guardian already archived']);
        exit;
    }

    // Step 3: Assign values
    $g_ID = $guardian['g_ID'];
    $g_FirstName = $guardian['g_FirstName'] ?? '';
    $g_LastName = $guardian['g_LastName'] ?? '';
    $st_ID = $guardian['st_ID'] ?? '';
    $st_name = $guardian['st_name'] ?? '';
    $g_Address = $guardian['g_Address'] ?? '';
    $g_PhoneNumber = $guardian['g_PhoneNumber'] ?? '';

    // Step 4: Insert into archive table
    $archiveStmt = $conn->prepare("
        INSERT INTO guardian_archive (
            g_ID, g_FirstName, g_LastName,
            st_ID, st_name, g_Address, g_PhoneNumber
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $archiveStmt->bind_param(
        "issssss",
        $g_ID,
        $g_FirstName,
        $g_LastName,
        $st_ID,
        $st_name,
        $g_Address,
        $g_PhoneNumber
    );

    if ($archiveStmt->execute()) {
        // Step 5: Delete from original table
        $deleteStmt = $conn->prepare("DELETE FROM t_guardians WHERE g_ID = ?");
        $deleteStmt->bind_param("i", $g_ID);
        $deleteStmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Insert into archive failed',
            'mysqli_error' => $archiveStmt->error
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
