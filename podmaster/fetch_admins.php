<?php
// fetch_admins.php
header('Content-Type: application/json');
include 'db_connection.php'; // Make sure this file contains your $conn connection

try {
    // Only fetch admins where a_username = 'staff'
       $sql = "SELECT * FROM t_admins WHERE a_Role IN ('staff', 'admin') ORDER BY a_ID ASC";

    $result = $conn->query($sql);

    $admins = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
    }

    echo json_encode($admins);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
