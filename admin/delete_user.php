<?php
session_start();
include("check_auth.php");
include("db_connection.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        if($current_role=="admin"){
        header("Location: users_list.php");
        }else{header("location:CRS.php");}
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
