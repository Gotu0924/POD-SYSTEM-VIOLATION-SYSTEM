<?php
session_start();
include '../includes/db_connection.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password = $_POST['password'];

    // ---------- Check Admin/Staff ----------
    $stmt = $conn->prepare("SELECT a_username, a_password, a_Role FROM t_admins WHERE a_username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($a_username, $a_password, $a_role);
        $stmt->fetch();

        if (password_verify($password, $a_password)) {
            $_SESSION['id'] = $a_username;
            $a_role = strtolower(trim($a_role));

            // Success → return redirect target
            switch ($a_role) {
                case 'superadmin':
                case '(super)admin':
                case 'admin':
                    echo json_encode(['success' => true, 'redirect' => 'index3.php']);
                    break;
                case 'staff':
                    echo json_encode(['success' => true, 'redirect' => 'staff.php']);
                    break;
                default:
                    echo json_encode(['success' => false, 'field' => 'general', 'message' => 'Unrecognized role.']);
            }
            exit();
        } else {
            echo json_encode(['success' => false, 'field' => 'password', 'message' => 'Incorrect password.']);
            exit();
        }
    }
    $stmt->close();

    // ---------- Check Student ----------
    $stmt = $conn->prepare("SELECT st_ID, s_Password FROM t_students WHERE st_ID = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($st_ID, $s_password);
        $stmt->fetch();

        if (password_verify($password, $s_password)) {
            $_SESSION['student_id'] = $st_ID;
            echo json_encode(['success' => true, 'redirect' => '../student/student.php']);
            exit();
        } else {
            echo json_encode(['success' => false, 'field' => 'password', 'message' => 'Invalid password!']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'field' => 'username', 'message' => 'Username/ID not found!']);
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
