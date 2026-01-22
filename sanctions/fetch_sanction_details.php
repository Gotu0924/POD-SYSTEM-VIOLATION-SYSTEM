<?php
// Include database connection file
include '../includes/db_connection.php';

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Sanitize and get the ID

    // Prepare the SQL query to fetch all sanction details based on the provided ID
    $query = "SELECT * FROM t_issues WHERE i_ID = ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);  // Bind the ID to the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the result contains data
        if ($result->num_rows > 0) {
            // Fetch the data as an associative array
            $sanction = $result->fetch_assoc();
            
            // Return the data as JSON
            echo json_encode($sanction);
        } else {
            // Return an error if no sanction is found for the given ID
            echo json_encode(['error' => 'Sanction not found']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    echo json_encode(['error' => 'No ID provided']);
}

// Close the database connection
$conn->close();
?>
    