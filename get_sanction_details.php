<?php
// Include your database connection file
include 'db_connection.php';

// Get the JSON data sent from the frontend
$data = json_decode(file_get_contents('php://input'), true);
$i_ID = $data['i_ID'];  // Get the i_ID

// SQL query to fetch the sanction details based on i_ID
$sql = "SELECT * FROM issues_archive WHERE i_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $i_ID);  // Bind the i_ID to the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$sanction = $result->fetch_assoc();

// Check if we found the sanction
if ($sanction) {
    // Return the sanction details as JSON
    echo json_encode($sanction);
} else {
    // If no sanction is found, return an error message
    echo json_encode(["error" => "Sanction not found"]);
}

// Close the connection
$stmt->close();
$conn->close();
?>
