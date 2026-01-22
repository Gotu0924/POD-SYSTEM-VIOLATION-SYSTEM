<?php
session_start();
include('../includes/db_connection.php'); // Make sure to include your DB configuration

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get session username
    $username = $_SESSION['id'];

    // Get the current, new, and confirm passwords from POST data
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if new password matches the confirmation password
    if ($newPassword !== $confirmPassword) {
        echo "New passwords do not match!";
        exit();
    }

    // Fetch the current password from the database
    $sql = "SELECT a_password FROM t_admins WHERE a_username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Check if the current password matches the one in the database
    if (password_verify($currentPassword, $storedPassword)) {
        // Hash the new password before storing it
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateSql = "UPDATE t_admins SET a_password = ? WHERE a_username = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('ss', $hashedNewPassword, $username);

        if ($updateStmt->execute()) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password.";
        }

        $updateStmt->close();
    } else {
        echo "Current password is incorrect!";
    }
}
?>
