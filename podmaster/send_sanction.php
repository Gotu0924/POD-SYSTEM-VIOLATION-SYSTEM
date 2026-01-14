<?php
// Include the database connection file
include 'db_connection.php';

// Start session to get staff username
session_start();

// Set the Content-Type header to JSON
header('Content-Type: application/json');

// Check if the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data from the POST request and escape
    $st_ID = $conn->real_escape_string($_POST['st_ID']);
    $i_Category = $conn->real_escape_string($_POST['i_Category']);
    $list_Offense = $conn->real_escape_string($_POST['list_Offense']);
    $i_Sanctions = $conn->real_escape_string($_POST['i_Sanctions']);
    $Suspension_Type = $conn->real_escape_string($_POST['Suspension_Type']);
    $i_Details = $conn->real_escape_string($_POST['i_Details']);
    $i_Recommendation = $conn->real_escape_string($_POST['i_Recommendation']);
    $i_Status = $conn->real_escape_string($_POST['i_Status']);

    // Get the staff username from session
    $a_username = $conn->real_escape_string($_SESSION['id'] ?? 'Unknown');

    // Default Suspension_Type if empty
    if (empty($Suspension_Type)) {
        $Suspension_Type = 'N/A';
    }

    // Generate a random violation number formatted to 4 digits
    $violation_number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    // 🔹 Fetch student's full name from t_students
    $st_name = '';
    $query_name = "SELECT s_Firstname, s_Middlename, s_Lastname FROM t_students WHERE st_ID = '$st_ID'";
    $result_name = $conn->query($query_name);
    if ($result_name && $row = $result_name->fetch_assoc()) {
        $st_name = trim($row['s_Firstname'] . ' ' . $row['s_Middlename'] . ' ' . $row['s_Lastname']);
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // 1. Insert into t_logs
        $query_logs = "INSERT INTO t_logs (
            violation_number, st_ID, st_name, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, a_username
        ) VALUES (
            '$violation_number', '$st_ID', '$st_name', '$i_Category', '$list_Offense', '$i_Sanctions', '$Suspension_Type', '$i_Details', '$i_Recommendation', '$i_Status', '$a_username'
        )";

        if ($conn->query($query_logs) !== TRUE) {
            throw new Exception('Error inserting into t_logs: ' . $conn->error);
        }

        // 2. Insert into t_issues
        $query_issues = "INSERT INTO t_issues (
            violation_number, st_ID, st_name, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, a_username
        ) VALUES (
            '$violation_number', '$st_ID', '$st_name', '$i_Category', '$list_Offense', '$i_Sanctions', '$Suspension_Type', '$i_Details', '$i_Recommendation', '$i_Status', '$a_username'
        )";

        if ($conn->query($query_issues) !== TRUE) {
            throw new Exception('Error inserting into t_issues: ' . $conn->error);
        }

        // 3. Insert into history_staff
        $query_history = "INSERT INTO history_staff (
            violation_number, st_ID, st_name, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, a_username, created_at
        ) VALUES (
            '$violation_number', '$st_ID', '$st_name', '$i_Category', '$list_Offense', '$i_Sanctions', '$Suspension_Type', '$i_Details', '$i_Recommendation', '$i_Status', '$a_username', NOW()
        )";

        if ($conn->query($query_history) !== TRUE) {
            throw new Exception('Error inserting into history_staff: ' . $conn->error);
        }

        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Sanction successfully sent to all tables.']);

    } catch (Exception $e) {
        // Rollback if any insert fails
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Close the connection
    $conn->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
