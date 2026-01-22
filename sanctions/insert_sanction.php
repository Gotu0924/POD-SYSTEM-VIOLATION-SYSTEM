<?php
header('Content-Type: application/json');

include '../includes/db_connection.php';
 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['s_ID'], $data['i_Offense'], $data['i_Details'], $data['i_Category'], $data['i_Severity'], $data['i_Recommendation'])) {
    $stmt = $conn->prepare("INSERT INTO t_issues (s_ID, i_Offense, i_Details, i_Category, i_Severity, i_Recommendation, i_Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $data['s_ID'], $data['i_Offense'], $data['i_Details'], $data['i_Category'], $data['i_Severity'], $data['i_Recommendation'], $data['i_Status']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid input"]);
}

$conn->close();
?>
