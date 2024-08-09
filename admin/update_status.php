<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_id = $_POST['id'];
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE blocks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $block_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'invalid_request';
}
?>
