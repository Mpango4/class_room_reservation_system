<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block_id = $_POST['id'];
    $block_name = $_POST['block_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE blocks SET block_name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $block_name, $description, $block_id);

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
