<?php
// Include the database connection file
require_once '../includes/db_connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form data
    $i_ID = isset($_POST['i_ID']) ? $_POST['i_ID'] : '';
    $i_Category = isset($_POST['i_Category']) ? $_POST['i_Category'] : '';
    $list_Offense = isset($_POST['list_Offense']) ? $_POST['list_Offense'] : '';
    $i_Sanctions = isset($_POST['i_Sanctions']) ? $_POST['i_Sanctions'] : '';
    $Suspension_Type = isset($_POST['Suspension_Type']) ? $_POST['Suspension_Type'] : '';
    $i_Details = isset($_POST['i_Details']) ? $_POST['i_Details'] : '';
    $i_Recommendation = isset($_POST['i_Recommendation']) ? $_POST['i_Recommendation'] : '';
    $i_Status = isset($_POST['i_Status']) ? $_POST['i_Status'] : '';
    $a_username = isset($_POST['a_username']) ? $_POST['a_username'] : '';

    // Validate that required fields are provided
    if (empty($i_ID) || empty($i_Category) || empty($list_Offense) || empty($i_Sanctions) || empty($Suspension_Type) || empty($i_Details) || empty($i_Recommendation) || empty($i_Status)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
        exit;
    }

    // SQL query to update the sanction in t_issues table
    $sql = "UPDATE t_issues
            SET i_Category = ?, list_Offense = ?, i_Sanctions = ?, Suspension_Type = ?, i_Details = ?, i_Recommendation = ?, i_Status = ?, a_username = ?
            WHERE i_ID = ?";

    // Prepare and bind the statement for t_issues update
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssi", $i_Category, $list_Offense, $i_Sanctions, $Suspension_Type, $i_Details, $i_Recommendation, $i_Status, $a_username, $i_ID);

        // Execute the statement
        if ($stmt->execute()) {
            // After successfully updating the sanction, update the history_staff table
            $updateHistorySQL = "UPDATE history_staff
                                 SET i_Status = ?
                                 WHERE violation_number = (SELECT violation_number FROM t_issues WHERE i_ID = ?)";

            if ($historyStmt = $conn->prepare($updateHistorySQL)) {
                $historyStmt->bind_param("si", $i_Status, $i_ID);

                // Execute the history update statement
                if ($historyStmt->execute()) {
                    // Now, update the i_Status in t_logs table using violation_number
                    $updateLogSQL = "UPDATE t_logs
                                     SET i_Status = ?
                                     WHERE violation_number = (SELECT violation_number FROM t_issues WHERE i_ID = ?)";

                    if ($logStmt = $conn->prepare($updateLogSQL)) {
                        $logStmt->bind_param("si", $i_Status, $i_ID);

                        // Execute the log update statement
                        if ($logStmt->execute()) {
                            echo json_encode(['success' => true, 'message' => 'Sanction updated successfully']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Failed to update t_logs']);
                        }

                        $logStmt->close();
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error preparing log update statement']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update history_staff']);
                }

                $historyStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Error preparing history update statement']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update sanction']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing SQL statement']);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
