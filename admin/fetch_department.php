<?php
include("db_connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, department_name, description FROM departments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $department = $result->fetch_assoc();

    echo json_encode($department);
}

$conn->close();
?>
