<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../includes/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardian_id'])) {
    $guardianId = intval($_POST['guardian_id']);

    // Step 1: Fetch the guardian details
    pg_prepare($conn, "fetch_stmt", "SELECT * FROM t_guardians WHERE g_ID = $1");
    $result = pg_execute($conn, "fetch_stmt", array($guardianId));
    $guardian = pg_fetch_assoc($result);

    if (!$guardian) {
        echo json_encode(['success' => false, 'error' => 'Guardian not found']);
        exit;
    }

    // Step 2: Check if already archived
    pg_prepare($conn, "check_stmt", "SELECT * FROM guardian_archive WHERE g_ID = $1");
    $checkResult = pg_execute($conn, "check_stmt", array($guardianId));

    if (pg_num_rows($checkResult) > 0) {
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
    pg_prepare($conn, "archive_stmt", "
        INSERT INTO guardian_archive (
            g_ID, g_FirstName, g_LastName,
            st_ID, st_name, g_Address, g_PhoneNumber
        ) VALUES ($1, $2, $3, $4, $5, $6, $7)
    ");

    $archiveResult = pg_execute($conn, "archive_stmt", array(
        $g_ID,
        $g_FirstName,
        $g_LastName,
        $st_ID,
        $st_name,
        $g_Address,
        $g_PhoneNumber
    ));

    if ($archiveResult) {
        // Step 5: Delete from original table
        pg_prepare($conn, "delete_stmt", "DELETE FROM t_guardians WHERE g_ID = $1");
        pg_execute($conn, "delete_stmt", array($g_ID));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Insert into archive failed',
            'pg_last_error' => pg_last_error($conn)
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
