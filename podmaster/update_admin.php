<?php
include 'db_connection.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id']);
$firstname = trim($data['firstname']);
$lastname = trim($data['lastname']);
$role = trim($data['role']);
$phone = trim($data['phone']);
$username = trim($data['username']);
$gmail = trim($data['gmail']);

if (!$firstname || !$lastname || !$role || !$phone || !$username || !$gmail) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Optional: further validation for phone and gmail
if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Invalid phone number format.']);
    exit;
}
if (!preg_match('/^[a-zA-Z0-9._%+-]+@smcbi\.edu\.ph$/', $gmail)) {
    echo json_encode(['success' => false, 'message' => 'Invalid Gmail address.']);
    exit;
}

// Update the admin
$stmt = $conn->prepare("UPDATE t_admins SET a_Firstname = ?, a_Lastname = ?, a_Role = ?, a_PhoneNumber = ?, a_username = ?, a_Gmail = ? WHERE a_ID = ?");
$stmt->bind_param("ssssssi", $firstname, $lastname, $role, $phone, $username, $gmail, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update admin.']);
}
?>
