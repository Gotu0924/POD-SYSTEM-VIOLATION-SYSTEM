<?php
// check_password_admin.php

session_start(); // Ensure session is started

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db_connection.php'); // Ensure your database connection is included
    $currentPassword = $_POST['currentPassword'] ?? '';
    $adminUsername = $_SESSION['id'] ?? ''; // Get logged-in admin username

    if (empty($currentPassword) || empty($adminUsername)) {
        echo json_encode(["status" => "error", "message" => "Missing required data."]);
        exit;
    }

    // Fetch the hashed password from the database
    // Replace with your actual database query
    $stmt = $conn->prepare("SELECT a_password FROM t_admins WHERE a_username = ?");
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();

    if ($admin && password_verify($currentPassword, $admin['a_password'])) {
        // Current password is correct
        echo json_encode(["status" => "success", "message" => "Current password verified."]);
    } else {
        // Current password is incorrect
        echo json_encode(["status" => "error", "message" => "Incorrect current password."]);
    }

    // $conn->close(); // Close database connection
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>