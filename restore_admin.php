<?php
// restore_admin.php
include 'db_connection.php'; // Include database connection

// Set response header for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_id'])) {
    $adminID = $_POST['admin_id'];

    // Step 1: Fetch the admin details from the archive table
    $selectQuery = "SELECT * FROM admins_archive WHERE a_ID = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("s", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Step 2: Get the admin details
        $admin = $result->fetch_assoc();

        // Step 3: Insert the admin details back into the t_admins table
        $insertQuery = "INSERT INTO t_admins (a_ID, a_Firstname, a_Lastname, a_Role, a_PhoneNumber, a_username, a_password, a_Gmail) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssssssss", 
            $admin['a_ID'],
            $admin['a_Firstname'],
            $admin['a_Lastname'],
            $admin['a_Role'],
            $admin['a_PhoneNumber'],
            $admin['a_username'],
            $admin['a_password'],
            $admin['a_Gmail']
        );

        // Step 4: Execute the insert
        if ($insertStmt->execute()) {
            // Step 5: Remove the admin from the archive table
            $deleteQuery = "DELETE FROM admins_archive WHERE a_ID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("s", $adminID);

            // Execute delete query
            if ($deleteStmt->execute()) {
                // Return success response
                echo json_encode([
                    'success' => true,
                    'message' => 'Admin restored successfully and removed from archive.'
                ]);
            } else {
                // Return error response if delete fails
                echo json_encode([
                    'success' => false,
                    'message' => 'Admin restored but failed to remove from archive.'
                ]);
            }
        } else {
            // Return error response if insert fails
            echo json_encode([
                'success' => false,
                'message' => 'Failed to restore admin. Please try again.'
            ]);
        }
    } else {
        // Return error response if admin not found in archive
        echo json_encode([
            'success' => false,
            'message' => 'Admin not found in archive.'
        ]);
    }
} else {
    // Return error if no admin_id provided in POST request
    echo json_encode([
        'success' => false,
        'message' => 'No admin ID provided.'
    ]);
}

// Close the database connection
$conn->close();
?>
