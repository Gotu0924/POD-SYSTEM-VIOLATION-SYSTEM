<?php
// Set content type to JSON
header('Content-Type: application/json');

include '../includes/db_connection.php';


// Get the ID from the URL query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure it's an integer

if ($id > 0) {
    // Prepare the DELETE query
    pg_prepare($conn, "delete_stmt", "DELETE FROM t_issues WHERE i_ID = $1");

    // Execute the statement
    $result = pg_execute($conn, "delete_stmt", array($id));
    if ($result) {
        if (pg_affected_rows($result) > 0) {
            // Deletion successful
            echo json_encode(["status" => "success", "message" => "Sanction deleted successfully."]);
        } else {
            // No rows affected (ID not found)
            echo json_encode(["status" => "error", "message" => "No sanction found with this ID."]);
        }
    } else {
        // Query execution failed
        echo json_encode(["status" => "error", "message" => "Execution failed: " . pg_last_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid ID provided."]);
}

// Close the database connection
pg_close($conn);
?>