<?php
header('Content-Type: application/json');
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['g_ID'])) {
    $id = intval($_POST['g_ID']);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid guardian ID.']);
        exit;
    }

    $conn->begin_transaction();
    try {
        $fetch = $conn->prepare("SELECT * FROM guardian_archive WHERE g_ID = ?");
        $fetch->bind_param("i", $id);
        $fetch->execute();
        $result = $fetch->get_result();
        $guardian = $result->fetch_assoc();
        $fetch->close();

        if (!$guardian) throw new Exception("Guardian not found in archive.");

        $insert = $conn->prepare("
            INSERT INTO t_guardians (g_ID, g_FirstName, g_LastName, st_ID, st_name, g_Address, g_PhoneNumber)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->bind_param(
            "issssss",
            $guardian['g_ID'],
            $guardian['g_FirstName'],
            $guardian['g_LastName'],
            $guardian['st_ID'],
            $guardian['st_name'],
            $guardian['g_Address'],
            $guardian['g_PhoneNumber']
        );
        if (!$insert->execute()) throw new Exception("Error inserting into active table.");
        $insert->close();

        $delete = $conn->prepare("DELETE FROM guardian_archive WHERE g_ID = ?");
        $delete->bind_param("i", $id);
        if (!$delete->execute()) throw new Exception("Error deleting from archive.");
        $delete->close();

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Guardian restored successfully.']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
