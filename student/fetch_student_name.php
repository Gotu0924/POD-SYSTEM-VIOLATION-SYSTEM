<?php
include '../includes/db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['st_ID'])) {
    $studentID = pg_escape_string($data['st_ID']);

    $query = "SELECT s_Firstname, s_Middlename, s_Lastname 
              FROM t_students 
              WHERE st_ID = '$studentID' LIMIT 1";
    $result = pg_query($conn, $query);

    if ($row = pg_fetch_assoc($result)) {
        $fullName = trim($row['s_Firstname'] . ' ' . $row['s_Middlename'] . ' ' . $row['s_Lastname']);
        echo json_encode(['success' => true, 'full_name' => $fullName]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Student not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No Student ID provided']);
}

pg_close($conn);
?>
