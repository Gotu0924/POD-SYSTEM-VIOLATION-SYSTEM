<?php
include '../includes/db_connection.php';

$response = ["status" => "error"]; // default

$sql = "SELECT * FROM t_students";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['st_ID'];
        $schoolYear = $row['school_year'];
        $yearLevel = (int)$row['year_level'];

        if ($yearLevel === 4) {
            // Archive Student
            $columns = [
                's_Firstname', 's_Middlename', 's_Lastname', 'st_ID', 's_DOB',
                's_CourseOfStudy', 'year_level', 's_Gender', 's_Address', 's_PhoneNumber', 'religion',
                'if_licence', 'if_licence_registration', 's_PicturePath', 's_Password',
                'school_year', 's_DateAdded', 's_gmail'
            ];

            $values = array_map(function($col) use ($row, $conn) {
                if ($col === 'year_level') {
                    return "'------'";
                }
                return "'" . mysqli_real_escape_string($conn, $row[$col]) . "'";
            }, $columns);

            $insertSQL = "INSERT INTO st_archive (" . implode(',', $columns) . ") 
                          VALUES (" . implode(',', $values) . ")";
            mysqli_query($conn, $insertSQL);

            // ✅ Archive Guardians also (matching st_ID)
            $guardianSQL = "SELECT * FROM t_guardians WHERE st_ID = '$id'";
            $guardianResult = mysqli_query($conn, $guardianSQL);

            if ($guardianResult && mysqli_num_rows($guardianResult) > 0) {
                while ($gRow = mysqli_fetch_assoc($guardianResult)) {
                    $gColumns = ['g_ID', 'g_FirstName', 'g_LastName', 'st_ID', 'st_name', 'g_Address', 'g_PhoneNumber'];

                    $gValues = array_map(function($col) use ($gRow, $conn) {
                        return "'" . mysqli_real_escape_string($conn, $gRow[$col]) . "'";
                    }, $gColumns);

                    $insertGuardianSQL = "INSERT INTO guardian_archive (" . implode(',', $gColumns) . ") 
                                          VALUES (" . implode(',', $gValues) . ")";
                    mysqli_query($conn, $insertGuardianSQL);

                    // delete guardian after archiving
                    $deleteGuardianSQL = "DELETE FROM t_guardians WHERE g_ID = '" . $gRow['g_ID'] . "'";
                    mysqli_query($conn, $deleteGuardianSQL);
                }
            }

            // delete student after archiving
            $deleteSQL = "DELETE FROM t_students WHERE st_ID = '$id'";
            mysqli_query($conn, $deleteSQL);

        } else {
            // ✅ Update year level and school year
            if (preg_match('/^(\d{4})-(\d{4})$/', $schoolYear, $matches)) {
                $startYear = (int)$matches[1] + 1;
                $endYear = (int)$matches[2] + 1;
                $newSchoolYear = "$startYear-$endYear";

                $newYearLevel = $yearLevel + 1;

                $updateSQL = "UPDATE t_students 
                              SET school_year = '$newSchoolYear', year_level = $newYearLevel 
                              WHERE st_ID = '$id'";
                mysqli_query($conn, $updateSQL);
            }
        }
    }
    $response["status"] = "success";
} else {
    $response["status"] = "error";
    $response["message"] = mysqli_error($conn);
}

mysqli_close($conn);
echo json_encode($response);
?>
