<?php
include("db_connection.php");

$response = array('success' => false);

if (isset($_POST['id']) && isset($_POST['department_name']) && isset($_POST['description'])) {
    $id = $_POST['id'];
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE departments SET department_name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $department_name, $description, $id);

    if ($stmt->execute()) {
        $response['success'] = true;
    }

    $stmt->close();
}

$conn->close();

echo json_encode($response);
?>
