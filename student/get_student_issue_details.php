<?php
session_start();

include '../includes/db_connection.php';
// Get the student ID from the session
$studentId = $_SESSION['student_id'];

// Prepare the SQL query to fetch issues for the logged-in student
$sql = "SELECT * FROM `t_issues` WHERE `st_ID` = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the student ID parameter
    mysqli_stmt_bind_param($stmt, "s", $studentId);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    $issues = array();
    if (mysqli_num_rows($result) > 0) {
        // Fetch all issues as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $issues[] = $row;
        }
        // Return the issues as JSON
        echo json_encode($issues);
    } else {
        // If no issues found for the student, return an error message
        echo json_encode(array("error" => "No issues found for this student."));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Error in preparing the statement
    echo json_encode(array("error" => "Error preparing SQL statement."));
}

// Close the database connection
mysqli_close($conn);
?>