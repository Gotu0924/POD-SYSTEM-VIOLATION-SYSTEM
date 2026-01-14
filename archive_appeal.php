<?php
include 'db_connection.php'; // DB connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appeal_ID'])) {
    $appealID = intval($_POST['appeal_ID']);

    // Step 1: Fetch the appeal
    $fetchSql = "SELECT * FROM t_appeals WHERE appeal_ID = ?";
    $stmt = $conn->prepare($fetchSql);
    $stmt->bind_param("i", $appealID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $appeal = $result->fetch_assoc();

        // Step 2: Insert into appeals_archive (including images & videos)
        $insertSql = "INSERT INTO appeals_archive 
            (appeal_ID, st_ID, violation_number, sender_name, sender_email, course, year_level, 
             l_appeal_message, images, videos, l_Time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param(
            "issssssssss",
            $appeal['appeal_ID'],
            $appeal['st_ID'],
            $appeal['violation_number'],
            $appeal['sender_name'],
            $appeal['sender_email'],
            $appeal['course'],
            $appeal['year_level'],
            $appeal['l_appeal_message'],
            $appeal['images'],
            $appeal['videos'],
            $appeal['l_Time']
        );

        if ($stmtInsert->execute()) {
            // Step 3: Delete from t_appeals
            $deleteSql = "DELETE FROM t_appeals WHERE appeal_ID = ?";
            $stmtDelete = $conn->prepare($deleteSql);
            $stmtDelete->bind_param("i", $appealID);
            $stmtDelete->execute();

            echo json_encode(["success" => true, "message" => "Appeal archived successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert into archive."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Appeal not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
