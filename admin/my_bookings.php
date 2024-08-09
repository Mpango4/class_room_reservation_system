<?php 
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php");



$user_id = $_SESSION['user_id'];

// Fetch bookings for the logged-in user
$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<main id="main" class="main">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Booking History</h5>
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
                                        <form method="post" action="cancel.php">
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
    </div>
</main>

<script>
    // Fade out the success message after 1 second
    setTimeout(function() {
        document.getElementById('success-message').style.opacity = '0';
    }, 1000);
</script>

<?php include('footer.php');?>
