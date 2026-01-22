<?php
// Include database connection file (adjust according to your setup)
include '../includes/db_connection.php';

// Get the appeal_ID from the request
$data = json_decode(file_get_contents("php://input"), true);
$appeal_ID = $data['appeal_ID'] ?? null;

if ($appeal_ID) {
    // Prepare the SQL query to fetch the appeal details
    $sql = "SELECT * FROM t_appeals WHERE appeal_ID = ?";
    
    // Prepare and bind the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $appeal_ID); // "i" means integer
        
        // Execute the query
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        
        // Check if appeal exists
        if ($result->num_rows > 0) {
            // Fetch the row
            $appeal = $result->fetch_assoc();
            
            // Return the appeal details in JSON format
            echo json_encode($appeal);
        } else {
            // Return an error message if appeal not found
            echo json_encode(["error" => "Appeal not found"]);
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Return an error message if query preparation fails
        echo json_encode(["error" => "Failed to prepare the SQL query"]);
    }
} else {
    // Return an error message if appeal_ID is not provided
    echo json_encode(["error" => "No appeal ID provided"]);
}

// Close the database connection
$conn->close();
?>
