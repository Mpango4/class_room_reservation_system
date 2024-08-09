<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php");

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$venue_id = $_GET['id'];

// Fetch venue details
$stmt = $conn->prepare("SELECT room_number FROM venues WHERE id = ?");
$stmt->bind_param("i", $venue_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $venue = $result->fetch_assoc();
} else {
    echo "Venue not found.";
    exit();
}

?>

<main id="main" class="main">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Venue Details</h5>
            <style>
                .schedule {
                    overflow-x: auto;
                    white-space: nowrap;
                    margin-bottom: 20px;
                }

                .room-number {
                    margin-bottom: 10px;
                    font-weight: bold;
                }

                .period {
                    display: inline-block;
                    width: 200px;
                    height: 60px;
                    margin-right: 5px;
                    border: 1px solid #ccc;
                    text-align: center;
                    line-height: 60px; /* Center the text vertically */
                    cursor: pointer;
                }

                .period:hover {
                    background-color: lightblue;
                }

                .hidden {
                    display: none;
                }

                .booked {
                    background-color: lightblue;
                    cursor: not-allowed;
                }
            </style>

            <!-- Display room number -->
            <div class="room-number">Room Number: <?php echo htmlspecialchars($venue['room_number']); ?></div>

            <div id="room-schedule" class="schedule"></div>
        </div>
    </div>
</div>
</main>

<script>
    function fetchRoomData() {
        var roomNumber = <?php echo json_encode($venue['room_number']); ?>;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log(response); // Debug: log the response
                    var roomData = response.room_data;
                    var bookings = response.bookings;
                    generateRoomSchedule(roomData, bookings);
                } else {
                    console.error('Error fetching room data: ' + xhr.status);
                }
            }
        };
        xhr.open('GET', 'fetch_room_data.php?room_number=' + roomNumber, true);
        xhr.send();
    }

    function generateRoomSchedule(data, bookings) {
        var roomNumber = <?php echo json_encode($venue['room_number']); ?>;
        var periods = data[roomNumber];
        if (!periods) {
            console.error('No periods found for room: ' + roomNumber);
            return;
        }
        var html = '';
        periods.forEach(function(period) {
            var bookedClass = (bookings[roomNumber] && bookings[roomNumber][period] === 'booked') ? 'booked' : '';
            html += "<div class='period " + bookedClass + "' onclick='bookPeriod(\"" + roomNumber + "\", \"" + period + "\")'>";
            html += "<div>" + period + "</div>";
            html += "</div>";
        });
        document.getElementById("room-schedule").innerHTML = html;
    }

    function bookPeriod(roomNumber, period) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'book_period.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Booking period: " + period);
                        fetchRoomData();
                    } else {
                        alert(response.message);
                    }
                } else {
                    console.error('Error booking period: ' + xhr.status);
                }
            }
        };
        xhr.send('room_number=' + encodeURIComponent(roomNumber) + '&period=' + encodeURIComponent(period));
    }

    fetchRoomData();
</script>

<?php include("footer.php"); ?>
