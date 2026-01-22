<?php
include '../includes/db_connection.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the guardian ID from the URL
$guardian_id = $_GET['id'];

// Query to fetch the guardian data
$sql = "SELECT * FROM t_guardians WHERE g_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $guardian_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any data is found
if ($result->num_rows > 0) {
    // Fetch the data
    $guardian = $result->fetch_assoc();
    
    // Return the data as a JSON response
    echo json_encode($guardian);
} else {
    echo json_encode(["error" => "Guardian not found"]);
}

// Close the connection
$stmt->close();
$conn->close();
?>