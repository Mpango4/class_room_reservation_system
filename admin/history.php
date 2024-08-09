<?php

include("db_connection.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings for the logged-in user
$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking_id'])) {
    $booking_id = $_POST['cancel_booking_id'];
    $cancel_sql = "DELETE FROM bookings WHERE id = ? AND user_id = ?";
    $cancel_stmt = $conn->prepare($cancel_sql);
    $cancel_stmt->bind_param("ii", $booking_id, $user_id);
    if ($cancel_stmt->execute()) {
        // Set a session variable to display the success message
        $_SESSION['booking_cancelled'] = true;
    } else {
        echo "<div class='alert alert-danger'>Error cancelling booking: " . $conn->error . "</div>";
    }
    $cancel_stmt->close();
}
?>


    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Booking History</h5>
                <?php
                // Check if the booking was successfully cancelled and display the success message
                if (isset($_SESSION['booking_cancelled']) && $_SESSION['booking_cancelled'] === true) {
                    echo "<div id='success-message' class='alert alert-success'>Booking cancelled successfully.</div>";
                    // Remove the session variable after displaying the message
                    unset($_SESSION['booking_cancelled']);
                }
                ?>
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Period</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['period']); ?></td>
                                    <td>
                                        <form method="post" action="dashboard.php">
                                            <input type="hidden" name="cancel_booking_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No bookings found.</p>
                <?php endif; ?>
               
            </div>
        </div>
    
<script>
    // Fade out the success message after 1 second
    setTimeout(function() {
        document.getElementById('success-message').style.opacity = '0';
    }, 1000);
</script>


