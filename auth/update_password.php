<?php
session_start();
include '../includes/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st_ID = $_POST['st_ID'] ?? '';
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';

    if (empty($st_ID) || empty($currentPassword) || empty($newPassword)) {
        echo json_encode(["success" => false, "field" => "general", "message" => "Missing required fields."]);
        exit;
    }

    // Fetch current password hash
    $stmt = $conn->prepare("SELECT s_Password FROM t_students WHERE st_ID = ?");
    $stmt->bind_param("s", $st_ID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo json_encode(["success" => false, "field" => "general", "message" => "Student not found."]);
        exit;
    }

    $stmt->bind_result($dbPassword);
    $stmt->fetch();

    // Verify current password
    if (!password_verify($currentPassword, $dbPassword)) {
        echo json_encode(["success" => false, "field" => "currentPassword", "message" => "Current password is incorrect."]);
        exit;
    }

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in DB
    $updateStmt = $conn->prepare("UPDATE t_students SET s_Password = ? WHERE st_ID = ?");
    $updateStmt->bind_param("ss", $hashedPassword, $st_ID);

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["success" => false, "field" => "general", "message" => "Failed to update password."]);
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "field" => "general", "message" => "Invalid request method."]);
}
?>
