<?php
// Database connection
include('../includes/db_connection.php'); // Ensure this file includes the connection setup

// SQL query to fetch all issues (sanctions) from t_issues table
$query = "SELECT * FROM issues_archive";
$result = pg_query($conn, $query);

$issues = [];

while ($row = pg_fetch_assoc($result)) {
    // Append each row to the issues array
    $issues[] = $row;
}

// Encode the result as JSON and return
echo json_encode($issues);

// Close the database connection
pg_close($conn);
?>
