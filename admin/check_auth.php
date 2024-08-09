<?php
//session_start();
$id = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$image = $_SESSION['image'];
$email = $_SESSION['email'];
$department = $_SESSION['department'];
$phonenumber = $_SESSION['phonenumber'];
$class = $_SESSION['class'];
$images = "uploads/" . $image;

// Check if the user is logged in
if (!isset($id) || empty($id) || !isset($_SESSION['role']) || empty($_SESSION['role'])) {
    // Redirect to the login page
    header("Location: ../logins.php");
    exit;
}

// Check if the user has the correct role and ID
$allowed_roles = array('admin', 'hod', 'CR', 'Lecture');
$current_role = $_SESSION['role'];

// Check if the role is allowed
if (!in_array($current_role, $allowed_roles)) {
    // Redirect to unauthorized page
    echo "Unauthorized access.";
    session_unset();
    session_destroy();
    exit;
}
?>
