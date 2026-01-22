<?php
include('../includes/db_connection.php'); // Include database connection file

// SQL query to fetch violations from the database
$query = "SELECT * FROM t_issues";
$result = pg_query($conn, $query);

$violations = [];

if (pg_num_rows($result) > 0) {
    // Fetch each row of data and add it to the $violations array
    while ($row = pg_fetch_assoc($result)) {
        $violations[] = $row;
    }
}

// Set the response header to indicate it's JSON
header('Content-Type: application/json');

// Output the violations data as JSON
echo json_encode($violations);

// Close the database connection
pg_close($conn);
?>
