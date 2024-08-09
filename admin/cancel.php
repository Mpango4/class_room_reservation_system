<?php
session_start();
include("check_auth.php");
include("db_connection.php");
$user_id = $_SESSION['user_id'];
// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking_id'])) {
    $booking_id = $_POST['cancel_booking_id'];
    $cancel_sql = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    $cancel_stmt = $conn->prepare($cancel_sql);
    $cancel_stmt->bind_param("ii", $booking_id, $user_id);
    if ($cancel_stmt->execute()) {
        // Set a session variable to display the success message
       header("location:my_bookings.php");
    } else {
        echo "<div class='alert alert-danger'>Error cancelling booking: " . $conn->error . "</div>";
    }
    $cancel_stmt->close();
}
?>