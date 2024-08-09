<?php 
session_start();
include("check_auth.php");
?>
<?php
include("db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department'];
    $class = $_POST['class'];
    $phonenumber = $_POST['phonenumber'];
    $role = $_POST['role'];
    $image = $_FILES['image']['name'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Upload image to a directory
    $image_name = $_FILES["image"]["name"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];

    // Upload image to a directory
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image_name);
    move_uploaded_file($image_tmp_name, $target_file);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, department, phonenumber, role, image, class) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssssss", $firstname, $lastname, $email, $hashed_password, $department, $phonenumber, $role, $image, $class);

    // Execute the statement
    if ($stmt->execute()) {
        if ($current_role == "admin") {
            header("location:users_list.php");
        } elseif ($current_role == "hod") {
            header("location:CRS.php");
        } else {
            // Handle other roles or cases if necessary
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
