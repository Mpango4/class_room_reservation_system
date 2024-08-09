<?php
include("db_connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger'>You must be logged in to submit a comment.</div>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $comment_description = $_POST['comment_description'];
    $recommendation = isset($_POST['recommendation']) ? $_POST['recommendation'] : '';

    // Validate the form data
    if (empty($comment_description)) {
        echo "<div class='alert alert-danger'>Comment description is required.</div>";
    } else {
        // Insert the comment into the database
        $sql = "INSERT INTO comments (user_id, comment_description, recommendation) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $comment_description, $recommendation);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Comment submitted successfully, our maintainence team is working on it. Thanks for reaching us</div>";
        } else {
            echo "<div class='alert alert-danger'>Error submitting comment: " . $conn->error . "</div>";
        }
        
        $stmt->close();
    }
}
?>
