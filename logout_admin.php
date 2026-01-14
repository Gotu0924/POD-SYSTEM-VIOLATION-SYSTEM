<?php
session_start(); // Start the session to access session variables

// Check if action is set to logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Destroy the session to log out the user
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to the login page (or home page) after logout
    header("Location: login.php"); // Change to your desired redirect page
    exit(); // Stop further script execution
}
?>