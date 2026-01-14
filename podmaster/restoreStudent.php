<?php
// restoreStudent.php
include 'db_connection.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentID = $_POST['studentID'];

    // 1. Get student data from archive table
    $selectQuery = "SELECT * FROM st_archive WHERE s_ID = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($student = $result->fetch_assoc()) {
        // 2. Insert into t_students (updated query to match the new structure)
        $insertQuery = "INSERT INTO t_students 
            (`s_ID`, `s_Firstname`, `s_Middlename`, `s_Lastname`, `st_ID`, `s_DOB`, 
             `s_CourseOfStudy`, `year_level`, `s_Gender`, `s_Address`, `s_PhoneNumber`, 
             `religion`, `if_licence`, `if_licence_registration`, `s_PicturePath`, 
             `s_Password`, `school_year`, `s_DateAdded`, `s_gmail`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param(
            "isssissssssssssssss",
            $student['s_ID'],
            $student['s_Firstname'],
            $student['s_Middlename'],
            $student['s_Lastname'],
            $student['st_ID'],
            $student['s_DOB'],
            $student['s_CourseOfStudy'],
            $student['year_level'],
            $student['s_Gender'],
            $student['s_Address'],
            $student['s_PhoneNumber'],
            $student['religion'],
            $student['if_licence'],
            $student['if_licence_registration'],
            $student['s_PicturePath'],
            $student['s_Password'],
            $student['school_year'],
            $student['s_DateAdded'],
            $student['s_gmail'] // Assuming the `s_gmail` is present in the archive table as well
        );

        if ($insertStmt->execute()) {
            // 3. Optionally delete from archive
            $deleteQuery = "DELETE FROM st_archive WHERE s_ID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $studentID);
            $deleteStmt->execute();

            echo json_encode(['success' => true, 'message' => 'Student restored successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert student.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Student not found in archive.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
