<?php
require 'db_connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $studentId = intval($_POST['student_id']);

    $stmt = $conn->prepare("SELECT * FROM t_students WHERE s_ID = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        $originalPath = $student['s_PicturePath'];
        $fileName = basename($originalPath);
        $newDirectory = 'archives/students/';
        $newPath = $newDirectory . $fileName;

        if (!is_dir($newDirectory)) {
            mkdir($newDirectory, 0777, true);
        }

        if ($originalPath && file_exists($originalPath)) {
            rename($originalPath, $newPath);
        } else {
            $newPath = '';
        }

        try {
            // ✅ First check if st_ID already exists in archive
            $checkStmt = $conn->prepare("SELECT COUNT(*) as cnt FROM st_archive WHERE st_ID = ?");
            $checkStmt->bind_param("s", $student['st_ID']);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result()->fetch_assoc();

            if ($checkResult['cnt'] > 0) {
                // Duplicate Student ID found
                echo json_encode(['success' => false, 'error' => 'duplicated-id']);
                exit;
            }

           $archiveStmt = $conn->prepare("
                    INSERT INTO st_archive (
                        s_Firstname, s_Middlename, s_Lastname, st_ID, 
                        s_DOB, s_CourseOfStudy, year_level, s_Gender, s_Address, 
                        s_PhoneNumber, religion, if_licence, if_licence_registration, 
                        s_DateAdded, s_PicturePath, s_Password, school_year, s_gmail
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $archiveStmt->bind_param(
                    "ssssssssssssssssss",
                    $student['s_Firstname'], $student['s_Middlename'], 
                    $student['s_Lastname'], $student['st_ID'], $student['s_DOB'], 
                    $student['s_CourseOfStudy'], $student['year_level'], $student['s_Gender'], 
                    $student['s_Address'], $student['s_PhoneNumber'], $student['religion'], 
                    $student['if_licence'], $student['if_licence_registration'], 
                    $student['s_DateAdded'], $newPath, $student['s_Password'], 
                    $student['school_year'], $student['s_gmail']
                );


            if ($archiveStmt->execute()) {
                $delStmt = $conn->prepare("DELETE FROM t_students WHERE s_ID = ?");
                $delStmt->bind_param("i", $studentId);
                $delStmt->execute();

                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'insert-failed']);
            }
        } catch (mysqli_sql_exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'student-not-found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'invalid-request']);
}
