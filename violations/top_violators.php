<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the MySQLi DB connection
include '../includes/db_connection.php';

// Query to get top 5 students with most violations + full name
$sql = "
    SELECT 
        i.st_ID,
        CONCAT(s.s_Firstname, ' ', s.s_Middlename, ' ', s.s_Lastname) AS full_name,
        COUNT(*) AS violation_count
    FROM t_issues i
    LEFT JOIN t_students s ON i.st_ID = s.st_ID
    GROUP BY i.st_ID, full_name
    ORDER BY violation_count DESC
    LIMIT 5
";

// Execute query and fetch results
$result = $conn->query($sql);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

// Fetch data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
?>
