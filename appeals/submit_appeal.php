<?php
header('Content-Type: application/json');
include '../includes/db_connection.php'; // contains $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st_ID = $_POST['appealStudentId'] ?? '';
    $violation_number = $_POST['violation_number'] ?? '';
    $sender_name = $_POST['appealStudentName'] ?? '';
    $sender_email = $_POST['appealStudentEmail'] ?? '';
    $course = $_POST['appealCourse'] ?? '';
    $year_level = $_POST['appealYearLevel'] ?? '';
    $l_appeal_message = $_POST['appealMessage'] ?? '';
    $l_Time = date('Y-m-d H:i:s');

    // Directories for saving files
    $img_dir = "podmaster/st_img/";
    $vid_dir = "podmaster/st_vid/";

    // Ensure directories exist
    if (!is_dir($img_dir)) {
        mkdir($img_dir, 0777, true);
    }
    if (!is_dir($vid_dir)) {
        mkdir($vid_dir, 0777, true);
    }

    // Handle image uploads
    $uploaded_images = [];
    if (!empty($_FILES['appealImages']['name'][0])) {
        foreach ($_FILES['appealImages']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['appealImages']['name'][$key]);
            $target_file = $img_dir . uniqid("img_") . "_" . $file_name;
            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_images[] = $target_file;
            }
        }
    }

    // Handle video uploads
    $uploaded_videos = [];
    if (!empty($_FILES['appealVideos']['name'][0])) {
        foreach ($_FILES['appealVideos']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['appealVideos']['name'][$key]);
            $target_file = $vid_dir . uniqid("vid_") . "_" . $file_name;
            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_videos[] = $target_file;
            }
        }
    }

    // Convert arrays to comma-separated strings for DB
    $images = implode(",", $uploaded_images);
    $videos = implode(",", $uploaded_videos);

    if (!empty($st_ID) && !empty($violation_number) && !empty($l_appeal_message)) {
        $stmt = $conn->prepare("INSERT INTO t_appeals 
            (st_ID, violation_number, sender_name, sender_email, course, year_level, l_appeal_message, images, videos, l_Time) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", 
            $st_ID, $violation_number, $sender_name, $sender_email, $course, $year_level, 
            $l_appeal_message, $images, $videos, $l_Time);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Your appeal has been submitted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Please fill in all required fields."]);
    }
}
$conn->close();
?>
