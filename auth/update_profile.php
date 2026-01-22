<?php
session_start();
include '../includes/db_connection.php'; // your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $st_ID       = $_POST['st_ID'];
    $dob         = $_POST['dob'];
    $gender      = $_POST['gender'];
    $address     = $_POST['address'];
    $phone       = $_POST['phone'];
    $religion    = $_POST['religion'];
    $license     = $_POST['license'];
    $licenseReg  = $_POST['licenseReg'];
    $s_gmail     = $_POST['s_gmail'];

    // handle profile photo upload
    $photoPath = null;
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
        $uploadDir = "st_images/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName = uniqid() . "_" . basename($_FILES['profilePic']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFile)) {
            $photoPath = $targetFile;
        }
    }

    // Build update query
    $sql = "UPDATE t_students SET 
                s_gmail = ?, 
                s_DOB = ?, 
                s_Gender = ?, 
                s_Address = ?, 
                s_PhoneNumber = ?, 
                religion = ?, 
                if_licence = ?, 
                if_licence_registration = ?";

    if ($photoPath) {
        $sql .= ", s_PicturePath = ?";
    }
    $sql .= " WHERE st_ID = ?";

    $stmt = $conn->prepare($sql);

    if ($photoPath) {
        $stmt->bind_param("ssssssssss", 
            $s_gmail, $dob, $gender, $address, $phone, $religion, $license, $licenseReg, $photoPath, $st_ID
        );
    } else {
        $stmt->bind_param("sssssssss", 
            $s_gmail, $dob, $gender, $address, $phone, $religion, $license, $licenseReg, $st_ID
        );
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
