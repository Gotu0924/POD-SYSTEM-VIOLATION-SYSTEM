<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

$duplicates = []; // Array to hold duplicate entries

if (isset($_FILES['csv_file']['tmp_name'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== false) {
        $rowCount = 0;
        $importSuccess = true; // Flag to track success

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rowCount++;

            // Skip header row
            if ($rowCount == 1) continue;

            // Trim all data
            $data = array_map('trim', $data);

            // Check column count (should now be at least 25 due to new s_gmail field)
            if (count($data) < 23) {
                echo "Row $rowCount has missing columns.<br>";
                continue;
            }

            // =================== Students ===================
            $s_ID                    = !empty($data[0]) ? (int)$data[0] : null;
            $s_Firstname             = $data[1] ?? '';
            $s_Middlename            = $data[2] ?? '';
            $s_Lastname              = $data[3] ?? '';
            $st_ID                   = $data[4] ?? '';
            $s_DOB                   = $data[5] ?? null;
            $s_CourseOfStudy         = $data[6] ?? '';
            $year_level              = !empty($data[7]) ? (int)$data[7] : null;
            $s_Gender                = $data[8] ?? '';
            $s_Address               = $data[9] ?? '';
            $s_PhoneNumber           = $data[10] ?? '';
            $s_gmail                 = $data[11] ?? '';
            $religion                = $data[12] ?? '';
            $if_licence              = $data[13] ?? '';
            $if_licence_registration = $data[14] ?? '';
            $s_PicturePath           = $data[15] ?? '';
            $s_Password              = !empty($data[16]) ? password_hash($data[16], PASSWORD_DEFAULT) : password_hash('default123', PASSWORD_DEFAULT);
            $school_year             = $data[17] ?? '';

            // Current date for s_DateAdded
            $s_DateAdded = date("Y-m-d H:i:s");

            // Check if student already exists
            $checkStudentStmt = $conn->prepare("SELECT s_ID FROM t_students WHERE s_ID = ?");
            $checkStudentStmt->bind_param("i", $s_ID);
            $checkStudentStmt->execute();
            $checkStudentStmt->store_result();

            if ($checkStudentStmt->num_rows > 0) {
                $duplicates[] = "Student with s_ID $s_ID already exists.";
            } else {
                //19
                $stmt = $conn->prepare("INSERT INTO t_students 
                    (s_ID, s_Firstname, s_Middlename, s_Lastname, st_ID, s_DOB, s_CourseOfStudy, year_level, s_Gender, s_Address, s_PhoneNumber, s_gmail, religion, if_licence, if_licence_registration, s_PicturePath, s_Password, school_year, s_DateAdded) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");//19

                $stmt->bind_param(
                    "isssissssssssssssss",
                    $s_ID, $s_Firstname, $s_Middlename, $s_Lastname, $st_ID, $s_DOB, $s_CourseOfStudy, $year_level, $s_Gender, $s_Address, $s_PhoneNumber, $s_gmail, $religion, $if_licence, $if_licence_registration, $s_PicturePath, $s_Password, $school_year, $s_DateAdded
                );

                if (!$stmt->execute()) {
                    echo "Student insert error (row $rowCount): " . $stmt->error . "<br>";
                    $importSuccess = false;
                }
            }

           // =================== Guardians ===================
$g_ID          = !empty($data[18]) ? (int)$data[18] : null;
$g_FirstName   = $data[19] ?? '';  // Adjust column index
$g_LastName    = $data[20] ?? '';  // Adjust column index
$g_st_ID       = $st_ID; // link to student

// Fetch the student's full name (First, Middle, and Last)
$getStudentNameStmt = $conn->prepare("SELECT s_Firstname, s_Middlename, s_Lastname FROM t_students WHERE s_ID = ?");
$getStudentNameStmt->bind_param("i", $st_ID);
$getStudentNameStmt->execute();
$getStudentNameStmt->store_result();
$getStudentNameStmt->bind_result($s_Firstname, $s_Middlename, $s_Lastname);
$getStudentNameStmt->fetch();

// Combine Firstname, Middlename, and Lastname into the student's full name
$g_st_name = $s_Firstname . ' ' . $s_Middlename . ' ' . $s_Lastname; // Full name

$getStudentNameStmt->close();

$g_Address     = $data[21] ?? '';  // Adjust column index
$g_PhoneNumber = $data[22] ?? '';  // Adjust column index

$checkGuardianStmt = $conn->prepare("SELECT g_ID FROM t_guardians WHERE g_ID = ?");
$checkGuardianStmt->bind_param("i", $g_ID);
$checkGuardianStmt->execute();
$checkGuardianStmt->store_result();

if ($checkGuardianStmt->num_rows > 0) {
    $duplicates[] = "Guardian with g_ID $g_ID already exists.";
} else {
    $stmt2 = $conn->prepare("INSERT INTO t_guardians 
        (g_ID, g_FirstName, g_LastName, st_ID, st_name, g_Address, g_PhoneNumber)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt2->bind_param(
        "issssss",
        $g_ID, $g_FirstName, $g_LastName, $g_st_ID, $g_st_name, $g_Address, $g_PhoneNumber
    );

    if (!$stmt2->execute()) {
        echo "Guardian insert error (row $rowCount): " . $stmt2->error . "<br>";
        $importSuccess = false;
    }
}

        }

        fclose($handle);

        // Redirect if there are duplicates
        if (!empty($duplicates)) {
            $duplicatesString = urlencode(implode(", ", $duplicates));
            echo '<script>window.location.href = "index3.php?duplicates=' . $duplicatesString . '";</script>';
            exit;
        }

        if ($importSuccess) {
            echo '<script>window.location.href="index3.php";</script>';
        } else {
            echo "There were errors during the import.";
        }
        exit;
    } else {
        echo "Failed to open CSV file.";
    }
} else {
    echo "No file uploaded.";
}
?>
