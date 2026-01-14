<?php
include 'db_connection.php'; // Include your database connection

// Get the Student ID from the POST request
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Query to check if the Student ID exists
    $sql = "SELECT * FROM t_students WHERE st_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the ID exists
    if ($result->num_rows > 0) {
        echo 'exists'; // Student ID exists
    } else {
        echo 'not_exists'; // Student ID does not exist
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo 'not_exists'; // No Student ID provided
}
?>
