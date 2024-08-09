<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$room_number = $_POST['room_number'];
$period = $_POST['period'];

// Check if the period is already booked
$query = "SELECT status FROM bookings WHERE room_number=? AND period=? AND status='booked'";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $room_number, $period);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Period already booked']);
    exit;
}

// Book the period
$query = "INSERT INTO bookings (room_number, period, user_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $room_number, $period, $user_id);
$stmt->execute();

echo json_encode(['success' => true, 'message' => 'Period booked successfully']);
?>
