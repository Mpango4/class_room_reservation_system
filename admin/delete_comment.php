<?php
include("db_connection.php");

$response = array('success' => false);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
    }

    $stmt->close();
}

$conn->close();

echo json_encode($response);
?>
