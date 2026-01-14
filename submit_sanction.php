<?php
session_start(); // Start the session to access session variables
include 'db_connection.php'; // Make sure this connects to your database

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Fetch session username (make sure 'id' is stored in the session)
    $a_username = $_SESSION['id'] ?? ''; // Replace 'id' with the actual session variable holding the username

    $st_ID = $_POST['st_ID'] ?? '';
    $i_Category = $_POST['i_Category'] ?? '';
    $list_Offense = $_POST['list_Offense'] ?? '';
    $i_Sanctions = $_POST['i_Sanctions'] ?? ''; 
    $Suspension_Type = $_POST['Suspension_Type'] ?? 'N/A';
    $i_Details = $_POST['i_Details'] ?? '';
    $i_Recommendation = $_POST['i_Recommendation'] ?? '';
    $i_Status = $_POST['i_Status'] ?? '';

    // If "Reprimand" or "Exclusion" is selected, set Suspension_Type to "N/A"
    if ($i_Sanctions === 'Reprimand' || $i_Sanctions === 'Exclusion') {
        $Suspension_Type = 'N/A';
    }

    // Generate a random violation number formatted as 0000
    $violation_number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    if (empty($i_Sanctions) || empty($a_username) || empty($st_ID)) {
        $response['message'] = "Please fill all required fields and ensure you're logged in.";
    } else {
        // 🔹 Fetch student's full name from t_students
        $st_name = '';
        $query = "SELECT s_Firstname, s_Middlename, s_Lastname FROM t_students WHERE st_ID = ?";
        $stmtName = $conn->prepare($query);
        if ($stmtName) {
            $stmtName->bind_param("s", $st_ID);
            $stmtName->execute();
            $result = $stmtName->get_result();
            if ($row = $result->fetch_assoc()) {
                $st_name = trim($row['s_Firstname'] . ' ' . $row['s_Middlename'] . ' ' . $row['s_Lastname']);
            }
            $stmtName->close();
        }

        // Insert into t_issues with st_name
        $sql = "INSERT INTO t_issues (violation_number, st_ID, st_name, i_Category, list_Offense, i_Sanctions, Suspension_Type, i_Details, i_Recommendation, i_Status, a_username) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssssssssss", 
                $violation_number, 
                $st_ID, 
                $st_name, 
                $i_Category, 
                $list_Offense, 
                $i_Sanctions, 
                $Suspension_Type, 
                $i_Details, 
                $i_Recommendation, 
                $i_Status, 
                $a_username
            );
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['message'] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = "SQL preparation error.";
        }
    }
} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
?>
