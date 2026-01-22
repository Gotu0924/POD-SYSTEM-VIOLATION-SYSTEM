<?php
include '../includes/db_connection.php';
header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Extract variables
$g_ID = $data->id;  // ID should be passed in the body of the POST request
$g_FirstName = $data->firstname;
$g_LastName = $data->lastname;
$g_PhoneNumber = $data->phone;
$g_Address = $data->address;
$st_ID = $data->studentID;

// Prepare and execute the SQL query (without the date_of_birth and religion columns)
$stmt = $conn->prepare("UPDATE t_guardians SET g_FirstName=?, g_LastName=?, g_PhoneNumber=?, g_Address=?, st_ID=? WHERE g_ID=?");
$stmt->bind_param("sssssi", $g_FirstName, $g_LastName, $g_PhoneNumber, $g_Address, $st_ID, $g_ID);

// Execute and check if the query was successful
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Guardian updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update guardian."]);
}

$stmt->close();
$conn->close();
?>
