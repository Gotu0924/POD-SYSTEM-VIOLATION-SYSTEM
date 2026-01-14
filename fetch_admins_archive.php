<?php
include 'db_connection.php'; // Include your database connection file

$sql = "SELECT * FROM admins_archive";
$result = $conn->query($sql);

$admins = [];
if ($result->num_rows > 0) {
    // Fetch all results
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
} else {
    // No data found
    $admins = ["message" => "No admins found."];
}

header('Content-Type: application/json');
echo json_encode($admins);

$conn->close();
?>
