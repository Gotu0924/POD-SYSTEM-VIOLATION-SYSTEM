<?php
// Include the database connection file
include 'db_connection.php';

// Set the Content-Type header to JSON for API responses
header('Content-Type: application/json');

// Check if the 'id' parameter is provided via GET request
if (isset($_GET['id'])) {
    // Get the log ID from the GET request and sanitize it
    $logId = $_GET['id'];

    // Prepare the SQL query to delete the log entry based on the provided log ID using a prepared statement
    $query = "DELETE FROM t_logs WHERE i_ID = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter (logId) to the statement
        $stmt->bind_param("s", $logId); // "s" means string type

        // Execute the statement
        if ($stmt->execute()) {
            // If the log is deleted successfully, return a success message
            echo json_encode(['success' => true, 'message' => 'Log deleted successfully.']);
        } else {
            // If there’s an error, return an error message
            echo json_encode(['success' => false, 'message' => 'Error deleting log: ' . $stmt->error]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If the prepare statement fails, return an error message
        echo json_encode(['success' => false, 'message' => 'Error preparing SQL query.']);
    }
} else {
    // If 'id' is not provided, return an error message
    echo json_encode(['success' => false, 'message' => 'No log ID provided.']);
}

// Close the database connection
$conn->close();
?>
