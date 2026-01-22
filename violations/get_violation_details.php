<?php
session_start();
include '../includes/db_connection.php';

// Check if violation ID is passed
if (isset($_GET['id'])) {
    $violationId = $_GET['id'];

    // Fetch violation details from database
    $query = "SELECT * FROM t_issues WHERE i_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $violationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch data
        $violation = $result->fetch_assoc();

        // Return data as JSON
        echo json_encode(['violation' => $violation]);
    } else {
        echo json_encode(['violation' => null]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['violation' => null]);
}
?>
