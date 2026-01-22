<?php
include '../includes/db_connection.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['userInput'])) {
    echo json_encode(['success'=>false, 'message'=>'Invalid input.']);
    exit;
}

$userInput = pg_escape_string($data['userInput']);

// Check if user exists
$sql = "SELECT a_ID, a_Gmail FROM t_admin WHERE a_username='$userInput' OR a_Gmail='$userInput'";
$result = pg_query($conn, $sql);

if(pg_num_rows($result) === 0) {
    echo json_encode(['success'=>false, 'message'=>'No account found with that username or Gmail.']);
    exit;
}

$row = pg_fetch_assoc($result);
$a_ID = $row['a_ID'];
$email = $row['a_Gmail'];

// Generate a secure token
$token = bin2hex(random_bytes(50));
$expiry = date("Y-m-d H:i:s", strtotime('+30 minutes'));

// Store token in DB (make sure you have reset_token and token_expiry columns)
pg_query($conn, "UPDATE t_admin SET reset_token='$token', token_expiry='$expiry' WHERE a_ID='$a_ID'");

// Localhost: simulate sending email
$resetLink = "http://localhost/podmaster/reset_password.php?token=$token"; // <-- local link
$subject = "Password Reset Request";
$message = "Click the link to reset your password: $resetLink\nThis link expires in 30 minutes.";

// Commented out real mail() for localhost testing
// $headers = "From: no-reply@yourdomain.com\r\n";
// mail($email, $subject, $message, $headers);

// For testing: just return the link so you can click it in browser
echo json_encode(['success'=>true, 'message'=>"Password reset link (localhost test): $resetLink"]);
