<?php
$servername = "localhost";
$username = "u490212423_dams";
$password = "Yamyam0924";
$dbname = "u490212423_dams";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
