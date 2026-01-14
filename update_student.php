<?php
include 'db_connection.php';

// Ensure the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
            s_Firstname = ?, 
            s_Middlename = ?, 
            s_Lastname = ?, 
            s_DOB = ?, 
            s_CourseOfStudy = ?, 
            year_level = ?, 
            school_year = ?, 
            s_Gender = ?,
            s_Address = ?, 
            s_PhoneNumber = ?, 
            religion = ?, 
            if_licence = ?, 
            if_licence_registration = ?, 
            s_gmail = ?,
            st_ID = ?
        WHERE s_ID = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing SQL statement: " . $conn->error);
}

// Correct bind_param call
// Types: 15 's' for strings, 1 'i' for integer (st_ID), 1 'i' for integer (id)
$stmt->bind_param(
    "sssssssssssssssi", 
    $firstname, 
    $middlename, 
    $lastname, 
    $dob, 
    $course, 
    $year_level, 
    $school_year, 
    $gender, 
    $address, 
    $phone, 
    $religion, 
    $licence, 
    $licence_registration, 
    $gmail, 
    $st_ID, 
    $id
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => true]);
}

$stmt->close();
$conn->close();
?>