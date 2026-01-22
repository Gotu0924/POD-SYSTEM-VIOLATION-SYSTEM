<?php
// Set content type to JSON
header('Content-Type: application/json');

include '../includes/db_connection.php';
// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}
// Check if ID is provided in the query parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Your database deletion query (ensure it’s prepared correctly to prevent SQL injection)
    $stmt = $conn->prepare("DELETE FROM t_admins WHERE a_ID = ?");
    $stmt->bind_param("s", $id); // Assuming s_ID is a string, adjust if it's different
    $success = $stmt->execute();

    if ($success) {
        // Return success response
        echo json_encode(["success" => true]);
    } else {
        // Return error response if deletion fails
        echo json_encode(["success" => false, "message" => "Failed to delete student"]);
    }
    
    $stmt->close();
} else {
    // Return error response if ID is not provided
    echo json_encode(["success" => false, "message" => "No student ID provided"]);
}

// Close the database connection
$conn->close();
?>