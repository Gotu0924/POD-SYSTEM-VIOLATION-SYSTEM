<?php
// ../admin/add_../admin/admin.php
include '../includes/db_connection.php'; 

// Get raw POST data
$data = file_get_contents('php://input');
$inputData = json_decode($data, true);

// Debugging: log what PHP receives
file_put_contents('debug_admin.txt', print_r($inputData, true));

if ($inputData && isset(
    $inputData['firstname'], 
    $inputData['lastname'], 
    $inputData['role'], 
    $inputData['phone'], 
    $inputData['username'], 
    $inputData['password']
)) {
    // Sanitize input
    $firstname = pg_escape_string($inputData['firstname']);
    $lastname  = pg_escape_string($inputData['lastname']);
    $role      = pg_escape_string($inputData['role']);
    $phone     = pg_escape_string($inputData['phone']);
    $username  = pg_escape_string($inputData['username']);
    $password  = pg_escape_string($inputData['password']);

    // Gmail is optional, but sanitize if provided
    $gmail = '';
    if (isset($inputData['gmail']) && !empty(trim($inputData['gmail']))) {
        $gmailValue = trim($inputData['gmail']);
        // Optional: enforce @smcbi.edu.ph format
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@smcbi\.edu\.ph$/', $gmailValue)) {
            echo json_encode(['success' => false, 'error' => 'Email must end with @smcbi.edu.ph']);
            exit;
        }
        $gmail = pg_escape_string($gmailValue);
    }

    // Check for duplicate username
    $checkQuery = "SELECT * FROM t_admins WHERE a_username = '$username'";
    $checkResult = pg_query($conn, $checkQuery);

    if (pg_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'error' => 'Username already taken']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $query = "INSERT INTO t_admins 
              (a_Firstname, a_Lastname, a_Role, a_PhoneNumber, a_username, a_Gmail, a_password)
              VALUES ('$firstname', '$lastname', '$role', '$phone', '$username', '$gmail', '$hashedPassword')";

    if (pg_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add admin: ' . pg_last_error($conn)]);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data received']);
}

pg_close($conn);
?>
