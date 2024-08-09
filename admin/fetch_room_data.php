<?php
include("db_connection.php");

// Fetch room numbers from the database
$sql = "SELECT DISTINCT room_number FROM venues where status ='active'";
$result = $conn->query($sql);

$roomNumbers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roomNumbers[] = $row["room_number"];
    }
}

// Predefined periods
$periods = [
    "7:00am - 8:00am",
    "8:00am - 9:00am",
    "9:00am - 10:00am",
    "10:00am - 11:00am",
    "11:00am - 12:00pm",
    "12:00pm - 1:00pm",
    "1:00pm - 2:00pm",
    "2:00pm - 3:00pm",
    "3:00pm - 4:00pm",
    "4:00pm - 5:00pm",
    "5:00pm - 6:00pm",
    "6:00pm - 7:00pm",
    "7:00pm - 8:00pm"
];

// Combine room numbers with predefined periods
$roomData = [];
foreach ($roomNumbers as $roomNumber) {
    $roomData[$roomNumber] = $periods;
}

// Fetch existing bookings
$sql = "SELECT room_number, period FROM bookings WHERE status='booked'";
$result = $conn->query($sql);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[$row['room_number']][$row['period']] = 'booked';
    }
}

$conn->close();

// Combine room data and bookings in the response
$response = [
    'room_data' => $roomData,
    'bookings' => $bookings
];

echo json_encode($response);
?>
