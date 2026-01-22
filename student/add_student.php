<?php
include '../includes/db_connection.php';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => "Connection failed: " . $e->getMessage()]);
    exit;
}

// Check if student ID already exists
$st_ID = $_POST['st_ID'];

$checkQuery = "SELECT COUNT(*) FROM t_students WHERE st_ID = :st_ID";
$stmt = $pdo->prepare($checkQuery);
$stmt->bindParam(':st_ID', $st_ID);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo json_encode(['error' => true, 'message' => 'Student ID already exists. Please enter a different ID.']);
    exit;
}

// Handle student picture upload
if (isset($_FILES['s_PicturePath'])) {
    $target_dir = "C:/xampp/htdocs/podmaster/st_images/";
    $target_file = $target_dir . basename($_FILES['s_PicturePath']['name']);
    
    if (move_uploaded_file($_FILES['s_PicturePath']['tmp_name'], $target_file)) {
        $s_PicturePath = 'st_images/' . basename($_FILES['s_PicturePath']['name']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Sorry, there was an error uploading your file.']);
        exit;
    }
} else {
    $s_PicturePath = null;
}

// Collect student data
$s_Firstname = $_POST['s_Firstname'];
$s_Middlename = $_POST['s_Middlename'];
$s_Lastname = $_POST['s_Lastname'];
$st_ID = $_POST['st_ID'];
$s_DOB = $_POST['s_DOB'];
$s_CourseOfStudy = $_POST['s_CourseOfStudy'];
$year_level = $_POST['year_level']; 
$school_year = $_POST['school_year']; 
$s_Gender = $_POST['s_Gender']; 
$s_Address = $_POST['s_Address'];
$s_PhoneNumber = $_POST['s_PhoneNumber'];
$religion = $_POST['religion'];
$gmail = $_POST['gmail']; // Get the value from the new 'gmail' field
$if_licence = $_POST['if_licence'];
$if_licence_registration = $_POST['if_licence_registration'];

// Encrypt password
$s_Password = $_POST['t_Password'];
$s_PasswordHash = password_hash($s_Password, PASSWORD_DEFAULT);

try {
    // Insert student
    $sql = "INSERT INTO t_students 
        (s_Firstname, s_Middlename, s_Lastname, st_ID, s_DOB, s_CourseOfStudy, year_level, school_year, s_Gender, s_Address, s_PhoneNumber, religion, s_gmail, if_licence, if_licence_registration, s_PicturePath, s_Password) 
        VALUES 
        (:s_Firstname, :s_Middlename, :s_Lastname, :st_ID, :s_DOB, :s_CourseOfStudy, :year_level, :school_year, :s_Gender, :s_Address, :s_PhoneNumber, :religion, :s_gmail, :if_licence, :if_licence_registration, :s_PicturePath, :s_Password)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':s_Firstname', $s_Firstname);
    $stmt->bindParam(':s_Middlename', $s_Middlename);
    $stmt->bindParam(':s_Lastname', $s_Lastname);
    $stmt->bindParam(':st_ID', $st_ID);
    $stmt->bindParam(':s_DOB', $s_DOB);
    $stmt->bindParam(':s_CourseOfStudy', $s_CourseOfStudy);
    $stmt->bindParam(':year_level', $year_level);
    $stmt->bindParam(':school_year', $school_year);
    $stmt->bindParam(':s_Gender', $s_Gender);
    $stmt->bindParam(':s_Address', $s_Address);
    $stmt->bindParam(':s_PhoneNumber', $s_PhoneNumber);
    $stmt->bindParam(':religion', $religion);
    $stmt->bindParam(':s_gmail', $gmail); // Bind the new parameter
    $stmt->bindParam(':if_licence', $if_licence);
    $stmt->bindParam(':if_licence_registration', $if_licence_registration);
    $stmt->bindParam(':s_PicturePath', $s_PicturePath);
    $stmt->bindParam(':s_Password', $s_PasswordHash);
    $stmt->execute();

    // Guardian data
    $g_Title = $_POST['g_Title'];
    $g_Firstname = $_POST['g_Firstname'];
    $g_Lastname = $_POST['g_Lastname'];
    $g_PhoneNumber = $_POST['g_PhoneNumber'];
    $g_Address = $_POST['g_Address'];

    // Build student full name as "Lastname, Firstname Middlename"
    $st_name = $s_Lastname . ', ' . $s_Firstname . ($s_Middlename ? ' ' . $s_Middlename : '');

    // Insert guardian
    $sql_guardian = "INSERT INTO t_guardians 
        (g_Firstname, g_Lastname, st_ID, st_name, g_Address, g_PhoneNumber) 
        VALUES 
        (:g_Firstname, :g_Lastname, :st_ID, :st_name,:g_Address, :g_PhoneNumber)";
    
    $stmt_guardian = $pdo->prepare($sql_guardian);
    $stmt_guardian->bindParam(':g_Firstname', $g_Firstname);
    $stmt_guardian->bindParam(':g_Lastname', $g_Lastname);
    $stmt_guardian->bindParam(':st_ID', $st_ID);
    $stmt_guardian->bindParam(':st_name', $st_name);
    $stmt_guardian->bindParam(':g_Address', $g_Address);
    $stmt_guardian->bindParam(':g_PhoneNumber', $g_PhoneNumber);
    $stmt_guardian->execute();

    echo json_encode(['success' => true, 'message' => 'Student and guardian added successfully!', 'student_name' => $st_name]);

} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => 'Error: ' . $e->getMessage()]);
}
?>