<?php
include "../includes/db_connection.php"; // Include your DB connection

if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);
    $sql = "SELECT * FROM tb_user WHERE reset_token='$token' AND reset_expires > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $conn->query("UPDATE tb_user SET password='$newPassword', reset_token=NULL, reset_expires=NULL WHERE reset_token='$token'");
            echo "Password has been reset successfully. <a href='../auth/login.php'>Login</a>";
            exit();
        }
    } else {
        echo "Invalid or expired token.";
        exit();
    }
}
?>

<form method="POST">
    <input type="password" name="password" placeholder="New Password" required>
    <input type="submit" value="Reset Password">
</form>
