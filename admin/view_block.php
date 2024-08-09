<?php
session_start();
include("db_connection.php");

$message = "";

// Edit Venue Functionality
if (isset($_GET['id'])) {
    $venue_id = $_GET['id'];
   
}



// Fetch block names from the block table
$blocks_query = "SELECT block_name FROM blocks";
$blocks_result = $conn->query($blocks_query);

// Fetch venue data from the venues table
$venues_query = "SELECT id, block_name, room_number, status FROM venues where block_name='$venue_id'";
$venues_result = $conn->query($venues_query);
?>

<?php include("header.php");?>
<?php include("sidebar.php");?>

<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Available Venues in  <span>| <?=$venue_id?></span></h5>
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
                        <th scope="col">venue Name</th>
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
        echo "<td>available</td>";
        echo "<td>
                <a href='view_venue.php?id=" . $row['id'] . "' class='fw-bold text-dark'>
                    View
                </a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No venues registered</td></tr>";
}
?>

                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("footer.php");?>
