<?php
session_start();

include '../includes/db_connection.php';
// Get the student ID from the session
$studentId = $_SESSION['student_id'];

// Prepare the SQL query to fetch issues for the logged-in student
$sql = "SELECT * FROM `t_issues` WHERE `st_ID` = ?";

// Prepare the statement
pg_prepare($conn, "issues_stmt", $sql);

$result = pg_execute($conn, "issues_stmt", array($studentId));

if ($result) {

    $issues = array();
    if (pg_num_rows($result) > 0) {
        // Fetch all issues as an associative array
        while ($row = pg_fetch_assoc($result)) {
            $issues[] = $row;
        }
        // Return the issues as JSON
        echo json_encode($issues);
    } else {
        // If no issues found for the student, return an error message
        echo json_encode(array("error" => "No issues found for this student."));
    }

} else {
    // Error in executing the query
    echo json_encode(array("error" => "Error executing SQL statement."));
}

// Close the database connection
pg_close($conn);
?>