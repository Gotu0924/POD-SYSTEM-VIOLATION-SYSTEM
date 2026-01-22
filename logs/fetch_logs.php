<?php
include '../includes/db_connection.php'; // Include your database connection file


$sql = "SELECT * FROM t_logs";
$result = $conn->query($sql);

$logs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

echo json_encode($logs);
$conn->close();
?>