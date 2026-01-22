<?php
session_start();
include('../includes/db_connection.php'); // Ensure your database connection is included

// Get the posted current password
$currentPassword = $_POST['currentPassword'];

// Fetch the current password from the database based on the session user
$username = $_SESSION['id']; // Assuming you store the user session ID

$sql = "SELECT a_password FROM t_admins WHERE a_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($storedPassword);
$stmt->fetch();
$stmt->close();

// Check if the entered password matches the stored one
if (password_verify($currentPassword, $storedPassword)) {
    echo json_encode(["valid" => true]);
} else {
    echo json_encode(["valid" => false]);
}
?>
