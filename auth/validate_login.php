<?php
session_start();
include '../includes/db_connection.php';

header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password = $_POST['password'];

    // ---------- Check Admin/Staff ----------
    pg_prepare($conn, "admin_check", "SELECT a_username, a_password, a_role FROM t_admins WHERE a_username = $1 LIMIT 1");
    $result = pg_execute($conn, "admin_check", array($username));

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);

        if (password_verify($password, $row['a_password'])) {
            $_SESSION['id'] = $row['a_username'];
            $a_role = strtolower(trim($row['a_role']));

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

    // ---------- Check Student ----------
    pg_prepare($conn, "student_check", "SELECT st_id, s_password FROM t_students WHERE st_id = $1 LIMIT 1");
    $result = pg_execute($conn, "student_check", array($username));

    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);

        if (password_verify($password, $row['s_password'])) {
            $_SESSION['student_id'] = $row['st_id'];
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

    pg_close($conn);
}
?>
