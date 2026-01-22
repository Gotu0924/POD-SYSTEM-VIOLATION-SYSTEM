<?php
session_start();
include '../includes/db_connection.php';

// Check if the student is logged in and session contains student ID
if (isset($_SESSION['student_id'])) {
    $studentId = $_SESSION['student_id'];  // Use session student ID

    // Fetch student details from t_students table based on session student_id
    $query = "SELECT s_Firstname, s_Middlename, s_Lastname, s_gmail, s_CourseOfStudy, year_level 
              FROM t_students WHERE st_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studentId);  // Bind the session student ID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch student data
        $student = $result->fetch_assoc();
        
        // Return the student details as a JSON response
        echo json_encode(['student' => $student]);
    } else {
        echo json_encode(['student' => null]);  // No student found for this ID
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['student' => null]);  // No student is logged in (no session)
}
?>
