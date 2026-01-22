<?php
// Fetch appeals from database
header('Content-Type: application/json');
include '../includes/db_connection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM t_appeals";
$result = $conn->query($sql);

$appeals = [];
while ($row = $result->fetch_assoc()) {
    $appeals[] = $row;
}

echo json_encode($appeals);

$conn->close();
?>
