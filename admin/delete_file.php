<?php
session_start();
include("db_connection.php");

if (isset($_GET['id'])) {
    $file_id = $_GET['id'];

    // Fetch the file information from the database
    $stmt = $conn->prepare("SELECT file_path FROM uploaded_files WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $file_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    if ($file_path) {
        // Delete the file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the file record from the database
        $stmt = $conn->prepare("DELETE FROM uploaded_files WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $file_id, $_SESSION['user_id']);
        if ($stmt->execute()) {
            $_SESSION['response_message'] = ['type' => 'alert-success', 'message' => 'File deleted successfully.'];
        } else {
            $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Failed to delete file from the database.'];
        }
        $stmt->close();
    } else {
        $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'File not found.'];
    }
} else {
    $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Invalid request.'];
}

$conn->close();
header("Location: files_list.php");
exit();
?>
