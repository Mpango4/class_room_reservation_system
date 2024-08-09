<?php
session_start();
include("db_connection.php");

$message = "";

// Fetch block names from the block table
$blocks_query = "SELECT block_name FROM blocks";
$blocks_result = $conn->query($blocks_query);

// Edit Venue Functionality
if (isset($_GET['edit'])) {
    $venue_id = $_GET['edit'];

    // Retrieve venue details from the database
    $stmt = $conn->prepare("SELECT * FROM venues WHERE id = ?");
    $stmt->bind_param("i", $venue_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
    } else {
        $message = "Venue not found.";
    }

    $stmt->close();
}

// Update Venue Functionality
if (isset($_POST['update'])) {
    $venue_id = $_POST['venue_id'];
    $block_name = $_POST['block_name'];
    $room_number = $_POST['room_number'];

    // Update venue details in the database
    $stmt = $conn->prepare("UPDATE venues SET block_name = ?, room_number = ? WHERE id = ?");
    $stmt->bind_param("ssi", $block_name, $room_number, $venue_id);

    if ($stmt->execute()) {
        $message = "Venue updated successfully.";
    } else {
        $message = "Error updating venue: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php include("header.php");?>
<?php include("sidebar.php");?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Venue</h5>
            <div id="message" class="alert alert-success message <?php if(isset($_SESSION['message'])) echo 'show'; ?>">
                <?php
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear session message
                }
                ?>
            </div>
            <form class="row g-3" action="venue.php" method="POST">
                <input type="hidden" name="venue_id" value="<?php echo $venue['id']; ?>">
                <div class="col-md-12">
                    <label for="room_number" class="form-label">Room Number</label>
                    <input type="text" class="form-control" id="room_number" name="room_number" value="<?php echo $venue['room_number']; ?>" required>
                </div>
                <div class="col-md-12">
                    <label for="block_name" class="form-label">Block Name</label>
                    <select class="form-select" id="block_name" name="block_name" required>
                        <option value="" selected>Select Block....</option>
                        <?php
                        if ($blocks_result->num_rows > 0) {
                            while ($row = $blocks_result->fetch_assoc()) {
                                $selected = ($venue['block_name'] == $row['block_name']) ? "selected" : "";
                                echo "<option value='" . $row['block_name'] . "' $selected>" . $row['block_name'] . "</option>";
                            }
                            // Move the result pointer back to the beginning for further use
                            $blocks_result->data_seek(0);
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <a href="venue.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include("footer.php");?>
