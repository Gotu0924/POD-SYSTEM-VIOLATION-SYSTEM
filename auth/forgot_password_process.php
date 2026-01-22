<?php
header('Content-Type: application/json');
include('../includes/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');

    if (empty($username)) {
        echo json_encode(['success' => false, 'field' => 'username', 'message' => 'Please enter your Username or Student ID.']);
        exit();
    }

    if (empty($email)) {
        echo json_encode(['success' => false, 'field' => 'email', 'message' => 'Please enter your Gmail.']);
        exit();
    }

    // Check Admin
    $adminResult = $conn->query("SELECT * FROM t_admins WHERE a_username='$username' AND a_gmail='$email' LIMIT 1");

    // Check Student
    $studentResult = $conn->query("SELECT * FROM t_students WHERE st_ID='$username' AND s_gmail='$email' LIMIT 1");

    if ($adminResult && $adminResult->num_rows > 0) {
        $accountType = 'admin';
    } elseif ($studentResult && $studentResult->num_rows > 0) {
        $accountType = 'student';
    } else {
        echo json_encode(['success' => false, 'field' => 'general', 'message' => 'No account found matching that Username/Student ID and Gmail.']);
        exit();
    }

    // Generate temporary password
    $tempPassword = bin2hex(random_bytes(4)); // 8 characters
    $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

    // Update the password
    if ($accountType === 'admin') {
        $update = $conn->query("UPDATE t_admins SET a_password='$hashedPassword' WHERE a_username='$username' AND a_gmail='$email'");
    } else {
        $update = $conn->query("UPDATE t_students SET s_password='$hashedPassword' WHERE st_ID='$username' AND s_gmail='$email'");
    }

    // Prepare email
    $to = $email;
    $subject = "SCMBIDAMS Password Reset";
    $message = "
Hello $username,

Your temporary password is: $tempPassword

Please login at https://scmbidams.com/../auth/login.php and change it immediately.

Thank you,
SCMBIDAMS Team
    ";

    $headers = "From: SCMBIDAMS <no-reply@scmbidams.com>\r\n";
    $headers .= "Reply-To: no-reply@scmbidams.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if ($update && mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Temporary password sent to your Gmail.']);
    } else {
        echo json_encode(['success' => false, 'field' => 'general', 'message' => 'Failed to send email. Please contact the administrator.']);
    }
}
?>
