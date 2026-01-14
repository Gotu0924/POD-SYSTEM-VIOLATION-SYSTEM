<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'])) {
    $adminId = intval($_POST['admin_id']);

    // Step 1: Fetch the admin details
    $stmt = $conn->prepare("SELECT * FROM t_admins WHERE a_ID = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        echo json_encode(['success' => false, 'error' => 'Admin not found']);
        exit;
    }

    // Step 2: Check if already archived (based on username instead of ID since archive has auto increment)
    $check = $conn->prepare("SELECT * FROM admins_archive WHERE a_username = ?");
    $check->bind_param("s", $admin['a_username']);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Admin already archived']);
        exit;
    }

    // Step 3: Assign admin values (removed a_Title as it's not in the table)
    $a_Firstname   = $admin['a_Firstname'] ?? '';
    $a_Lastname    = $admin['a_Lastname'] ?? '';
    $a_Role        = $admin['a_Role'] ?? '';
    $a_PhoneNumber = $admin['a_PhoneNumber'] ?? '';
    $a_username    = $admin['a_username'] ?? '';
    $a_password    = $admin['a_password'] ?? '';
    $a_Gmail       = $admin['a_Gmail'] ?? ''; // Ensure consistent variable name with the column

    // Step 4: Validate and format the phone number to 000-000-0000
    if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $a_PhoneNumber)) {
        // If phone number is not in correct format, reformat it
        $a_PhoneNumber = preg_replace('/[^0-9]/', '', $a_PhoneNumber); // Remove any non-numeric characters
        if (strlen($a_PhoneNumber) == 10) {
            $a_PhoneNumber = substr($a_PhoneNumber, 0, 3) . '-' . substr($a_PhoneNumber, 3, 3) . '-' . substr($a_PhoneNumber, 6);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid phone number format']);
            exit;
        }
    }

    // Step 5: Insert into archive (a_ID auto increment, so not included)
    $archiveStmt = $conn->prepare("
        INSERT INTO admins_archive (
            a_Firstname, a_Lastname, 
            a_Role, a_PhoneNumber, a_username, a_password, a_Gmail
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $archiveStmt->bind_param(
        "sssssss",
        $a_Firstname,
        $a_Lastname,
        $a_Role,
        $a_PhoneNumber,
        $a_username,
        $a_password,
        $a_Gmail
    );

    if ($archiveStmt->execute()) {
        // Step 6: Delete from original table
        $deleteStmt = $conn->prepare("DELETE FROM t_admins WHERE a_ID = ?");
        $deleteStmt->bind_param("i", $adminId);
        $deleteStmt->execute();

        echo json_encode([ 
            'success' => true, 
            'inserted' => [
                'a_Firstname'   => $a_Firstname,
                'a_Lastname'    => $a_Lastname,
                'a_Role'        => $a_Role,
                'a_PhoneNumber' => $a_PhoneNumber,
                'a_username'    => $a_username,
                'a_password'    => $a_password,
                'a_Gmail'       => $a_Gmail
            ]
        ]);
    } else {
        echo json_encode([ 
            'success' => false, 
            'error' => 'Insert into archive failed', 
            'mysqli_error' => $archiveStmt->error 
        ]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
