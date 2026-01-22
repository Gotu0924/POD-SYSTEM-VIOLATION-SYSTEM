<?php
// ../auth/check_gmail.php
include '../includes/db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$gmail = $conn->real_escape_string($data['gmail']);

$query = "SELECT * FROM t_admins WHERE a_Gmail = '$gmail'";
$result = $conn->query($query);

$response = ['isTaken' => false];

if ($result->num_rows > 0) {
    $response['isTaken'] = true;
}

echo json_encode($response);
?>
