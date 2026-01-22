<?php
// Include the database connection file
include '../includes/db_connection.php';

// Set the Content-Type header to JSON for API responses
header('Content-Type: application/json');

// Check if the 'id' parameter is provided via GET request
if (isset($_GET['id'])) {
    // Get the log ID from the GET request and sanitize it
    $logId = $conn->real_escape_string($_GET['id']);

    // Prepare the SQL query to fetch the log data based on the provided log ID
    $query = "SELECT * FROM t_logs WHERE i_ID = '$logId'";

    // Execute the query
    $result = $conn->query($query);

    // Check if the log exists
    if ($result->num_rows > 0) {
        // Fetch the log data as an associative array
        $logData = $result->fetch_assoc();

        // Return the log data as a JSON response
        echo json_encode([$logData]);
    } else {
        // If no log is found, return an error message
        echo json_encode(['success' => false, 'message' => 'Log not found.']);
    }
} else {
    // If 'id' is not provided, return an error message
    echo json_encode(['success' => false, 'message' => 'No log ID provided.']);
}

// Close the database connection
$conn->close();
?>
