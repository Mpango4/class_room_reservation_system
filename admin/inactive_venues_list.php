<?php
session_start();
include("db_connection.php");

$message = "";

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

// Delete Venue Functionality
if (isset($_POST['delete'])) {
    $venue_id = $_POST['delete'];

    // Delete venue from the database
    $stmt = $conn->prepare("DELETE FROM venues WHERE id = ?");
    $stmt->bind_param("i", $venue_id);

    if ($stmt->execute()) {
        $message = "Venue deleted successfully.";
    } else {
        $message = "Error deleting venue: " . $stmt->error;
    }

    $stmt->close();
}

// Toggle Status Functionality
if (isset($_POST['toggle_status'])) {
    $venue_id = $_POST['toggle_status'];

    // Retrieve current status of the venue
    $stmt = $conn->prepare("SELECT status FROM venues WHERE id = ?");
    $stmt->bind_param("i", $venue_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
        $current_status = $venue['status'];

        // Toggle the status
        $new_status = ($current_status == 'active') ? 'inactive' : 'active';

        // Update the status in the database
        $stmt = $conn->prepare("UPDATE venues SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $venue_id);

        if ($stmt->execute()) {
            $message = "Status updated successfully.";
        } else {
            $message = "Error updating status: " . $stmt->error;
        }
    } else {
        $message = "Venue not found.";
    }

    $stmt->close();
}

// Fetch block names from the block table
$blocks_query = "SELECT block_name FROM blocks";
$blocks_result = $conn->query($blocks_query);

// Fetch venue data from the venues table
$venues_query = "SELECT id, block_name, room_number, status FROM venues where status='inactive'";
$venues_result = $conn->query($venues_query);
?>

<?php include("header.php");?>
<?php include("sidebar.php");?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Registered Venues <span>| All</span></h5>
            <div id="message" class="alert alert-success message <?php if(isset($_SESSION['message'])) echo 'show'; ?>">
                <?php
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear session message
                }
                ?>
            </div>
            <table class="table table-borderless datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Block Name</th>
                        <th scope="col">Room Number</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($venues_result->num_rows > 0) {
                        while ($row = $venues_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row['id'] . "</th>";
                            echo "<td>" . $row['block_name'] . "</td>";
                            echo "<td>" . $row['room_number'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <a href='fetch_venue.php?edit=" . $row['id'] . "' class='btn btn-secondary'><i class='bi bi-pencil-square'></i> Edit</a>
                                    <form method='POST' style='display: inline;'>
                                        <button type='submit' class='btn btn-danger' name='delete' value='" . $row['id'] . "'><i class='bi bi-trash'></i> Delete</button>
                                    </form>
                                    <form method='POST' style='display: inline;'>
                                        <button type='submit' class='btn btn-info' name='toggle_status' value='" . $row['id'] . "'><i class='bi bi-toggle2'></i> Toggle Status</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No Iniactive venues </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("footer.php");?>
