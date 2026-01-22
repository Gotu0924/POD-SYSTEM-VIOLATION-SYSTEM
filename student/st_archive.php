<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/db_connection.php'; // Include your database connection file

$sql = "SELECT * FROM st_archive";
$result = $conn->query($sql);

$students = [];
if ($result->num_rows > 0) {
    // Fetch all results
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
} else {
    // No data found
    $students = ["message" => "No students found."];
}

header('Content-Type: application/json');
echo json_encode($students);

$conn->close();
?>
