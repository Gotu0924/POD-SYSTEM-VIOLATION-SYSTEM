<?php
// Include the database connection file
require_once 'db_connection.php'; // Adjust the path if needed

// Check if the violation_id is received from the POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['violation_id'])) {
    // Sanitize the input to prevent SQL injection
    $violationId = mysqli_real_escape_string($conn, $_POST['violation_id']);

    // Retrieve the violation details from t_issues table
    $sql = "SELECT * FROM t_issues
            WHERE i_ID = '$violationId'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the violation data
        $violation = mysqli_fetch_assoc($result);

        // Insert the violation into issues_archive table
        $insert_sql = "INSERT INTO issues_archive (i_ID, st_ID, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, violation_number, a_username)
                       VALUES ('" . $violation['i_ID'] . "', '" . $violation['st_ID'] . "', '" . $violation['i_Category'] . "', '" . $violation['list_Offense'] . "', '" . $violation['i_Sanctions'] . "', '" . $violation['Suspension_Type'] . "', '" . $violation['i_Details'] . "', '" . $violation['i_Recommendation'] . "', '" . $violation['i_Status'] . "', '" . $violation['violation_number'] . "', '" . $violation['a_username'] . "')";

        if (mysqli_query($conn, $insert_sql)) {
            // After successful insert, delete the violation from t_issues
            $delete_sql = "DELETE FROM t_issues WHERE i_ID = '$violationId'";
            if (mysqli_query($conn, $delete_sql)) {
                // Successfully archived and removed from t_issues
                echo json_encode(['success' => true]);
            } else {
                // Error deleting from t_issues
                echo json_encode(['success' => false, 'error' => 'Failed to delete from t_issues: ' . mysqli_error($conn)]);
            }
        } else {
            // Error inserting into issues_archive
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        // No violation found with the given ID
        echo json_encode(['success' => false, 'error' => 'Violation not found.']);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request or missing violation_id
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
