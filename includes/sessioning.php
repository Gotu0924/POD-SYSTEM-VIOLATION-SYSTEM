<?php
// ../student/student.php (Protected page)
session_start();

if (
    !isset($_SESSION['id']) || empty($_SESSION['id']) )


    // Add checks for other session variables if needed
{
   header("Location: ../auth/login.php");
 exit();
}

// User is logged in, display content:
//echo "Welcome, " . $_SESSION['id'] ."!";
// ... rest of your student page content
?>
