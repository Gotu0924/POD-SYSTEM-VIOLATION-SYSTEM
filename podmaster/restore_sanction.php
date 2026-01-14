<?php
// Include the database connection file
require_once 'db_connection.php'; // Adjust the path if needed

// Check if the necessary POST parameters are received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['i_ID'])) {
    $i_ID = $_POST['i_ID'];

    // Sanitize input to prevent SQL injection
    $i_ID = mysqli_real_escape_string($conn, $i_ID);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Fetch the violation details from the issues_archive table
        $fetch_sql = "SELECT * FROM issues_archive WHERE i_ID = ?";
        $stmt = $conn->prepare($fetch_sql);
        $stmt->bind_param("i", $i_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the data
            $sanction = $result->fetch_assoc();

            // Insert the record back into the t_issues table
            $insert_sql = "INSERT INTO t_issues (i_ID, st_ID, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, violation_number, a_username) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("issssssssss", $sanction['i_ID'], $sanction['st_ID'], $sanction['i_Category'], $sanction['list_Offense'], $sanction['i_Sanctions'], $sanction['Suspension_Type'], $sanction['i_Details'], $sanction['i_Recommendation'], $sanction['i_Status'], $sanction['violation_number'], $sanction['a_username']);
            $insert_stmt->execute();

            // Delete the record from the issues_archive table
            $delete_sql = "DELETE FROM issues_archive WHERE i_ID = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $i_ID);
            $delete_stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Send a success response
            echo json_encode(['success' => true, 'message' => 'Sanction successfully restored.']);
        } else {
            // If no matching record is found in the archive
            echo json_encode(['success' => false, 'message' => 'Sanction not found in the archive.']);
        }

        // Close the statement
        $stmt->close();
        $insert_stmt->close();
        $delete_stmt->close();
    } catch (Exception $e) {
        // In case of an error, rollback the transaction
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error restoring sanction: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

// Close the connection
$conn->close();
?>
