<?php
include 'db_connection.php'; // Include your database connection file

$sql = "SELECT * FROM t_guardians"; // Query to select all guardians
$result = $conn->query($sql);

$guardians = [];
if ($result->num_rows > 0) {
    // Fetch all results
    while ($row = $result->fetch_assoc()) {
        $guardians[] = $row; // Add each guardian to the array
    }
} else {
    // No data found
    $guardians = ["message" => "No guardians found."];
}

header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($guardians); // Return the guardians as a JSON response

$conn->close(); // Close the database connection
?>