<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM blocks WHERE id = ?");
    $stmt->bind_param("i", $block_id);

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
