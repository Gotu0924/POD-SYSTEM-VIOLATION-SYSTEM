<?php
// get_violation_number.php

$issueId = $_POST['issue_id'];
include 'db_connection.php'; // Include your database connection file
// Query to fetch violation number based on issue ID
$query = "SELECT violation_number FROM t_issues WHERE i_ID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $issueId);
$stmt->execute();
$stmt->bind_result($violationNumber);

if ($stmt->fetch()) {
    // Return the violation number in JSON format
    echo json_encode(['violation_number' => $violationNumber]);
} else {
    echo json_encode(['violation_number' => '']);
}

$stmt->close();
$connection->close();
?>
