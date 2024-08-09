<?php
session_start();
include("db_connection.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $block_name = $_POST['block_name'];
    $room_number = $_POST['room_number'];

    // Check if the venue already exists
    $stmt = $conn->prepare("SELECT id FROM venues WHERE block_name = ? AND room_number = ?");
    $stmt->bind_param("ss", $block_name, $room_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Venue already exists.";
    } else {
        // Insert the venue into the database
        $stmt = $conn->prepare("INSERT INTO venues (block_name, room_number) VALUES (?, ?)");
        $stmt->bind_param("ss", $block_name, $room_number);

        if ($stmt->execute()) {
            $message = "Venue added successfully.";
        } else {
            $message = "Error adding venue: " . $stmt->error;
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Set session variable for the message
    $_SESSION['message'] = $message;

    // Redirect to prevent form resubmission
    header("Location: venue.php");
    exit();
}

// Fetch block names from the block table
$blocks_query = "SELECT block_name FROM blocks";
$blocks_result = $conn->query($blocks_query);
?>

<?php include("header.php");?>
<?php include("sidebar.php");?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add New Room</h5>
            <div id="message" class="alert alert-success message <?php if(isset($_SESSION['message'])) echo 'show'; ?>">
                <?php
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear session message
                }
                ?>
            </div>
            <form class="row g-3" action="venue.php" method="POST">
                
                <div class="col-md-12">
                    <label for="room_number" class="form-label">Venue Name</label>
                    <input type="text" class="form-control" id="room_number" name="room_number" required>
                </div>
                <div class="col-md-12">
                    <label for="block_name" class="form-label">Block Name</label>
                    <select class="form-select" id="block_name" name="block_name" required>
                        <option value="" selected>Select Block....</option>
                        <?php
                        if ($blocks_result->num_rows > 0) {
                            while ($row = $blocks_result->fetch_assoc()) {
                                echo "<option value='" . $row['block_name'] . "'>" . $row['block_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include("footer.php");?>
