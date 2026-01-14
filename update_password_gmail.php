<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data safely
    $a_ID = intval($_POST['a_ID']); // ensure numeric ID
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password securely
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password and clear reset token & expiry
        $update_sql = "UPDATE t_admin 
                       SET a_password='$hashed', reset_token=NULL, token_expiry=NULL 
                       WHERE a_ID=$a_ID";

        if (mysqli_query($conn, $update_sql)) {
            echo "<div class='alert alert-success text-center'>
                    Password updated successfully. <a href='login.php'>Login</a>
                  </div>";
        } else {
            // DB update failed
            echo "<div class='alert alert-danger text-center'>
                    Failed to update password. Please try again.
                  </div>";
        }
    } else {
        // Passwords do not match
        echo "<div class='alert alert-danger text-center'>
                Passwords do not match!
              </div>";
    }
} else {
    // Invalid access
    echo "<div class='alert alert-warning text-center'>
            Invalid request method.
          </div>";
}
?>
