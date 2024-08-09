<?php
include("db_connection.php");

// Update the status of all bookings to 'available'
$sql = "UPDATE bookings SET status='available' WHERE status='booked'";
if ($conn->query($sql) === TRUE) {
    echo "Bookings reset successfully.";
} else {
    echo "Error resetting bookings: " . $conn->error;
}

$conn->close();
?>
