<?php
// deleteStudent.php

header('Content-Type: application/json');
require 'db_connection.php'; // Make sure this has your $conn variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentID'])) {
    $studentID = intval($_POST['studentID']);

    if ($studentID <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid student ID.'
        ]);
        exit;
    }

    // Example: delete from archive table
    $sql = "DELETE FROM st_archive WHERE s_ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("i", $studentID);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Student deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Student not found or already deleted.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error deleting student: ' . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
}
?>
