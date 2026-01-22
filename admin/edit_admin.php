<?php
include '../includes/db_connection.php';

$id = $_GET['id'];

// Prepare the SQL query for t_admins
$sql = "SELECT *
        FROM t_admins WHERE a_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);  // "i" for integer
$stmt->execute();
$result = $stmt->get_result();

// Check if admin exists
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    echo json_encode($admin);
} else {
    echo json_encode(['error' => 'Admin not found']);
}

$stmt->close();
$conn->close();
?>
