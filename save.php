<?php
include 'db_connection.php';
if (isset($_GET['id'])) {
    $logId = $_GET['id'];

    // Start transaction to ensure atomicity (either both operations succeed or fail)
    $conn->begin_transaction();

    // 1. Fetch data from t_logs based on the log ID
    $sql_select = "SELECT st_ID, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status FROM t_logs WHERE i_ID = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $logId);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();

        // 2. Insert the fetched data into t_issues
        $sql_insert = "INSERT INTO t_issues (s_ID, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssssss", $row['st_ID'], $row['i_Category'], $row['list_Offense'], $row['i_Sanctions'], $row['Suspension_Type'], $row['i_Details'], $row['i_Recommendation'], $row['i_Status']);

        if ($stmt_insert->execute()) {
            // 3. Delete the record from t_logs
            $sql_delete = "DELETE FROM t_logs WHERE i_ID = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $logId);

            if ($stmt_delete->execute()) {
                $conn->commit(); // Commit the transaction if both insert and delete were successful
                echo json_encode(['success' => true]);
            } else {
                $conn->rollback(); // Rollback the transaction if delete failed
                echo json_encode(['success' => false, 'message' => "Error deleting from t_logs: " . $stmt_delete->error]);
            }
            $stmt_delete->close();
        } else {
            $conn->rollback(); // Rollback the transaction if insert failed
            echo json_encode(['success' => false, 'message' => "Error inserting into t_issues: " . $stmt_insert->error]);
        }
        $stmt_insert->close();
    } else {
        echo json_encode(['success' => false, 'message' => "Log with ID $logId not found in t_logs."]);
    }
    $stmt_select->close();

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => "Log ID not provided."]);
}
?>