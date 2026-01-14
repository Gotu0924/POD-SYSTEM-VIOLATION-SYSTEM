<?php
// Include your database connection
include 'db_connection.php';  // Adjust the path as necessary

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    // Prepare the SQL query to delete the student from the 't_students' table
    $sql = "DELETE FROM st_archive WHERE s_ID = :studentID";

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);
        
        // Bind the student ID parameter to the SQL query
        $stmt->bindParam(':studentID', $studentID, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();

        // Check if a row was deleted
        if ($stmt->rowCount() > 0) {
            // Success message
            echo "Student with ID $studentID has been deleted successfully.";
        } else {
            // No student found with the given ID
            echo "Student with ID $studentID was not found.";
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: No student ID provided.";
}
?>
