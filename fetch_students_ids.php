// search_student_ids.php
<?php
// Include your database connection here
include 'db_connection.php';

// Get the search term from the query string (using GET)
$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

// Query to fetch student IDs based on the search term
$query = "SELECT st_ID FROM t_students WHERE st_ID LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $query);

// Initialize an array to store the student IDs
$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row['st_ID'];  // Storing the st_ID values
}

// Return the student IDs as a JSON response
echo json_encode($students);
?>
