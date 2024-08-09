<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted on a different server
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "soud_db"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
