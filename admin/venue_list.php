
<?php 
session_start();
include("header.php");
?>
<?php include("sidebar.php");?>

<main id="main" class="main">
<div class="col-lg-12">
        <div class="card">
        <div class="card-body">
                <h5 class="card-title">Venue List</h5>

    <style>
        /* Custom CSS for styling */
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
            width: 200px; /* Adjust width as needed */
            height: 60px;
            margin-right: 5px;
            border: 1px solid #ccc;
            text-align: center;
            line-height: 30px;
            cursor: pointer;
        }

        .period:hover {
            background-color: lightblue;
        }

        .hidden {
            display: none;
        }
    </style>


<!-- Search field -->
<input type="text" id="search" placeholder="Search room number" oninput="searchRoom()">

<div id="room-schedule" class="schedule"></div>
</div>
</div>
</div>
</main>
<script>
    // Function to fetch room data from the database
function fetchRoomData() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var roomData = response.room_data;
                var bookings = response.bookings;
                generateRoomSchedule(roomData, bookings);
            } else {
                console.error('Error fetching room data: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', 'fetch_room_data.php', true);
    xhr.send();
}

// Function to generate room schedule
function generateRoomSchedule(data, bookings) {
    var html = '';
    for (var roomNumber in data) {
        html += "<div class='room-number' id='room-" + roomNumber + "'>Room Number: " + roomNumber + "</div>";
        html += "<div class='schedule' id='schedule-" + roomNumber + "'>";
        data[roomNumber].forEach(function(period) {
            var bookedClass = (bookings[roomNumber] && bookings[roomNumber][period] === 'booked') ? 'booked' : '';
            html += "<div class='period " + bookedClass + "' onclick='bookPeriod(\"" + roomNumber + "\", \"" + period + "\")'>";
            html += "<div>" + period + "</div>";
            html += "</div>";
        });
        html += "</div>";
    }
    document.getElementById("room-schedule").innerHTML = html;
}

// Function to simulate booking a period
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
                    // Highlight the booked period
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

// Function to filter room numbers and their associated periods based on search query
function searchRoom() {
    var input, filter, rooms, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    rooms = document.getElementsByClassName("room-number");
    for (i = 0; i < rooms.length; i++) {
        txtValue = rooms[i].textContent || rooms[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            rooms[i].classList.remove("hidden");
            var roomNumber = rooms[i].id.split("-")[1];
            document.getElementById("schedule-" + roomNumber).classList.remove("hidden");
        } else {
            rooms[i].classList.add("hidden");
            var roomNumber = rooms[i].id.split("-")[1];
            document.getElementById("schedule-" + roomNumber).classList.add("hidden");
        }
    }
}

// Fetch room data and generate schedule
fetchRoomData();

</script>
<style>
    .booked {
        background-color: lightblue;
        cursor: not-allowed;
    }
</style>

<?php include("footer.php");