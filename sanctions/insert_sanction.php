<?php
header('Content-Type: application/json');

include '../includes/db_connection.php';
 


$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['s_ID'], $data['i_Offense'], $data['i_Details'], $data['i_Category'], $data['i_Severity'], $data['i_Recommendation'])) {
    pg_prepare($conn, "insert_stmt", "INSERT INTO t_issues (s_ID, i_Offense, i_Details, i_Category, i_Severity, i_Recommendation, i_Status) VALUES ($1, $2, $3, $4, $5, $6, $7)");
    $result = pg_execute($conn, "insert_stmt", array($data['s_ID'], $data['i_Offense'], $data['i_Details'], $data['i_Category'], $data['i_Severity'], $data['i_Recommendation'], $data['i_Status']));

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => pg_last_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid input"]);
}

pg_close($conn);
?>
