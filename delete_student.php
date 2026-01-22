
<?php
// Set content type to JSON
header('Content-Type: application/json');

include 'includes/db_connection.php';

// Check if ID is provided in the query parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Your database deletion query (ensure it’s prepared correctly to prevent SQL injection)
    pg_prepare($conn, "delete_stmt", "DELETE FROM t_students WHERE s_ID = $1");
    $result = pg_execute($conn, "delete_stmt", array($id));
    $success = $result !== false;

    if ($success) {
        // Return success response
        echo json_encode(["success" => true]);
    } else {
        // Return error response if deletion fails
        echo json_encode(["success" => false, "message" => "Failed to delete student"]);
    }

} else {
    // Return error response if ID is not provided
    echo json_encode(["success" => false, "message" => "No student ID provided"]);
}

// Close the database connection
pg_close($conn);
?>