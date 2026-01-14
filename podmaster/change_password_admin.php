<?php
// change_password_admin.php

session_start(); // Ensure session is started
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db_connection.php'); // Ensure your database connection is included
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $adminUsername = $_SESSION['id'] ?? ''; // Get logged-in admin username

    $errors = [];

    // --- Field Validations ---
    if (empty($currentPassword)) {
        $errors['currentPassword'] = "Current password is required.";
    }

    if (empty($newPassword)) {
        $errors['newPassword'] = "New password is required.";
    } elseif (strlen($newPassword) < 8) {
        $errors['newPassword'] = "New password must be at least 8 characters long.";
    }

    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = "Please confirm your new password.";
    } elseif ($newPassword !== $confirmPassword) {
        $errors['confirmPassword'] = "New passwords do not match.";
    }

    if (empty($adminUsername)) {
        $errors['adminUsername'] = "Session expired. Please login again.";
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "errors" => $errors]);
        exit;
    }

    // --- Re-verify Current Password ---
    $stmt = $conn->prepare("SELECT a_password FROM t_admins WHERE a_username = ?");
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();

    if (!$admin || !password_verify($currentPassword, $admin['a_password'])) {
        echo json_encode(["status" => "error", "errors" => ["currentPassword" => "Incorrect current password."]]);
        exit;
    }

    // --- Hash and Update Password ---
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateStmt = $conn->prepare("UPDATE t_admins SET a_password = ? WHERE a_username = ?");
    $updateStmt->bind_param("ss", $hashedNewPassword, $adminUsername);

    if ($updateStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "errors" => ["update" => "Failed to update password. Please try again later."]]);
    }

    $updateStmt->close();
} else {
    echo json_encode(["status" => "error", "errors" => ["method" => "Invalid request method."]]);
}
?>
