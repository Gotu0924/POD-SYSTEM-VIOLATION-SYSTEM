<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';

// Initialize an array to store duplicate usernames
$duplicates = [];

if (isset($_FILES['csv_file']['tmp_name'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== false) {
        $rowCount = 0;
        $importSuccess = true;

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rowCount++;

            // Skip header row
            if ($rowCount == 1) continue;

            // Trim all data
            $data = array_map('trim', $data);

            // Check for at least 7 columns (added Gmail)
            if (count($data) < 7) {
                echo "Row $rowCount has missing columns.<br>";
                continue;
            }

            // Assign values
            $a_ID          = !empty($data[0]) ? (int)$data[0] : null;
            $a_Firstname   = $data[1] ?? '';
            $a_Lastname    = $data[2] ?? '';
            $a_Role        = strtolower(trim($data[3] ?? '')); // Normalize role
            $a_PhoneNumber = $data[4] ?? '';
            $a_username    = $data[5] ?? '';
            $plainPassword = $data[6] ?? '';
            $a_Gmail       = $data[7] ?? '';

            // Validate role
            $valid_roles = ['admin','(super)admin',  'staff'];
            if (!in_array($a_Role, $valid_roles)) {
                echo "Skipped row $rowCount: Invalid role '$a_Role'.<br>";
                continue;
            }

            // Hash password (default to 'admin123' if empty)
            $a_Password = password_hash(!empty($plainPassword) ? $plainPassword : 'admin123', PASSWORD_DEFAULT);

            // Skip row if required fields are missing
            if (empty($a_Firstname) || empty($a_Lastname) || empty($a_username)) {
                echo "Skipped row $rowCount due to missing required fields.<br>";
                continue;
            }

            // Optional: Check for duplicate username
            $checkStmt = $conn->prepare("SELECT a_ID FROM t_admins WHERE a_username = ?");
            $checkStmt->bind_param("s", $a_username);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                // Collect duplicate usernames
                $duplicates[] = $a_username;
                $checkStmt->close();
                continue;
            }
            $checkStmt->close();

            // Insert into database including Gmail
            $stmt = $conn->prepare("INSERT INTO t_admins 
                    (a_ID, a_Firstname, a_Lastname, a_Role, a_PhoneNumber, a_username, a_password, a_Gmail) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "isssssss",
                $a_ID,
                $a_Firstname,
                $a_Lastname,
                $a_Role,
                $a_PhoneNumber,
                $a_username,
                $a_Password,
                $a_Gmail
            );

            if (!$stmt->execute()) {
                echo "Admin insert error (row $rowCount): " . $stmt->error . "<br>";
                $importSuccess = false;
            }

            $stmt->close();
        }

        fclose($handle);

        // If import is successful
        if ($importSuccess) {
            // If duplicates are found, pass them to the URL
            if (!empty($duplicates)) {
                $duplicatesString = implode(',', $duplicates);
                echo '<script>';
                echo 'window.location.href = "admin.php?duplicates=' . urlencode($duplicatesString) . '";';
                echo '</script>';
            } else {
                // Redirect to the same page (admin.php) to refresh
                echo '<script>window.location.href="admin.php";</script>';
            }
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
