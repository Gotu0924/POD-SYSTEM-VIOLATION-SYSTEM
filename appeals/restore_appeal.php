<?php
include '../includes/db_connection.php';
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['appeal_ID'])) {
    $appeal_ID = $data['appeal_ID'];

    // Fetch the appeal data from appeals_archive
    $stmt = $conn->prepare("SELECT * FROM appeals_archive WHERE appeal_ID = ?");
    $stmt->bind_param("i", $appeal_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $appeal = $result->fetch_assoc();

    if ($appeal) {
        // Insert the appeal data back into t_appeals (including images and videos)
        $stmt_insert = $conn->prepare("INSERT INTO t_appeals 
            (appeal_ID, st_ID, violation_number, sender_name, sender_email, course, year_level, 
             l_appeal_message, images, videos, l_Time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt_insert->bind_param(
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

        if ($stmt_insert->execute()) {
            // Delete from appeals_archive after restoring
            $stmt_delete = $conn->prepare("DELETE FROM appeals_archive WHERE appeal_ID = ?");
            $stmt_delete->bind_param("i", $appeal_ID);
            $stmt_delete->execute();

            echo json_encode(['success' => true, 'message' => 'Appeal restored successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to restore appeal.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Appeal not found in archive.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
