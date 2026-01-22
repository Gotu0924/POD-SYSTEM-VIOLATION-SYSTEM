<?php
include '../includes/db_connection.php';



$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$firstname = $data['firstname'];
$middlename = $data['middlename'];
$lastname = $data['lastname'];
$dob = $data['dob'];
$course = $data['course'];
$year_level = $data['year_level'];
$school_year = $data['school_year'];
$gender = $data['gender'];
$address = $data['address'];
$phone = $data['phone'];
$religion = $data['religion'];
$licence = $data['licence'];
$licence_registration = $data['licence_registration'];
$gmail = $data['gmail']; // Correct variable name
$studentID = $data['studentID']; // This variable is not used in the query, but is in the JSON payload
$st_ID = $data['st_ID'];

// Print the SQL query for debugging purposes
$sql = "UPDATE t_students SET
            s_Firstname = $1,
            s_Middlename = $2,
            s_Lastname = $3,
            s_DOB = $4,
            s_CourseOfStudy = $5,
            year_level = $6,
            school_year = $7,
            s_Gender = $8,
            s_Address = $9,
            s_PhoneNumber = $10,
            religion = $11,
            if_licence = $12,
            if_licence_registration = $13,
            s_gmail = $14,
            st_ID = $15
        WHERE s_ID = $16";

pg_prepare($conn, "update_stmt", $sql);

$result = pg_execute($conn, "update_stmt", array($firstname, $middlename, $lastname, $dob, $course, $year_level, $school_year, $gender, $address, $phone, $religion, $licence, $licence_registration, $gmail, $st_ID, $id));

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => pg_last_error($conn)]);
}
pg_close($conn);
?>