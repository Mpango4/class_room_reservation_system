<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $original_file_name = $_FILES['file']['name'];

    // Check if file with the same original name already exists in the database
    $stmt = $conn->prepare("SELECT id FROM uploaded_files WHERE original_file_name = ? AND user_id = ?");
    $stmt->bind_param("si", $original_file_name, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'A file with this name already exists.'];
        $stmt->close();
        header("Location: timetable.php");
        exit();
    }
    $stmt->close();

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $allowed_extensions = array('xlsx', 'xls', 'pdf');
        $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if (in_array($file_extension, $allowed_extensions)) {
            $file_type = ($file_extension == 'pdf') ? 'pdf' : 'excel';
            $unique_file_name = uniqid() . '.' . $file_extension;
            $file_path = 'uploads/' . $unique_file_name;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                $stmt = $conn->prepare("INSERT INTO uploaded_files (user_id, title, original_file_name, file_path, file_type) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $user_id, $title, $original_file_name, $file_path, $file_type);

                if ($stmt->execute()) {
                    $_SESSION['response_message'] = ['type' => 'alert-success', 'message' => 'File uploaded successfully.'];
                } else {
                    $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Database error: ' . $stmt->error];
                }

                $stmt->close();
            } else {
                $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Failed to move uploaded file.'];
            }
        } else {
            $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Invalid file type. Only Excel and PDF files are allowed.'];
        }
    } else {
        $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'No file uploaded or file upload error.'];
    }

    $conn->close();
    header("Location: timetable.php");
    exit();
} else {
    $_SESSION['response_message'] = ['type' => 'alert-danger', 'message' => 'Invalid request.'];
    header("Location: timetable.php");
    exit();
}
