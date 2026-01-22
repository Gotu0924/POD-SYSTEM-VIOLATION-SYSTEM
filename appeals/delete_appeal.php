<?php
include '../includes/db_connection.php';
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['appeal_ID'])) {
    $appeal_ID = $data['appeal_ID'];

    // Delete the appeal from appeals_archive
    $stmt = $conn->prepare("DELETE FROM appeals_archive WHERE appeal_ID = ?");
    $stmt->bind_param("i", $appeal_ID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
