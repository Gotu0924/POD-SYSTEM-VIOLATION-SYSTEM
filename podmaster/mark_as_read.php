<?php
// mark_as_read.php

// Include the database connection file
include 'db_connection.php';

// Set the Content-Type header to JSON for API responses
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID of the sanction to mark as read
    $data = json_decode(file_get_contents('php://input'), true);
    $sanctionId = $data['id'];

    // Update the sanction status to "read" in the database
    $query = "UPDATE t_logs SET is_read = 1 WHERE i_ID = '$sanctionId'";

    if ($conn->query($query) === TRUE) {
        // Respond with success
        echo json_encode(['success' => true, 'message' => 'Sanction marked as read.']);
    } else {
        // Respond with an error
        echo json_encode(['success' => false, 'message' => 'Error marking sanction as read.']);
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
