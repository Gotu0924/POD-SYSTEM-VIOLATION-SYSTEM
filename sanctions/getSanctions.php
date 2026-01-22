<?php
// Database connection
include('../includes/db_connection.php'); // Ensure this file includes the connection setup

// SQL query to fetch all issues (sanctions) from t_issues table
$query = "SELECT i_ID, i_Offense, i_Category, i_Details, i_Severity, i_Recommendation, i_Status, s_ID FROM t_issues";
$result = mysqli_query($conn, $query);

$sanctions = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Append each row to the sanctions array
    $sanctions[] = $row;
}

// Encode the result as JSON and return
echo json_encode($sanctions);

// Close the database connection
mysqli_close($conn);
?>
