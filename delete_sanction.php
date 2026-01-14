<?php
// Set content type to JSON
header('Content-Type: application/json');

include 'db_connection.php';
// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get the ID from the URL query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure it's an integer

if ($id > 0) {
    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM t_issues WHERE i_ID = ?");
    
    // Check if prepare was successful
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    // Bind the parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Deletion successful
            echo json_encode(["status" => "success", "message" => "Sanction deleted successfully."]);
        } else {
            // No rows affected (ID not found)
            echo json_encode(["status" => "error", "message" => "No sanction found with this ID."]);
        }
    } else {
        // Query execution failed
        echo json_encode(["status" => "error", "message" => "Execution failed: " . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid ID provided."]);
}

// Close the database connection
$conn->close();
?>