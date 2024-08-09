<?php
include("db_connection.php");

// Function to get the total number of users
function getTotalUsers($conn) {
    // Query to count the number of users
    $sql = "SELECT COUNT(*) AS total_users FROM users";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_users'];
    } else {
        return 0;
    }
}

// Get the total number of users
$total_users = getTotalUsers($conn);
// Get the total number of crs
function getTotalCrs($conn) {
    // Query to count the number of users
    $sql = "SELECT COUNT(*) AS total_crs FROM users where role = 'CR'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_crs'];
    } else {
        return 0;
    }
}

// Get the total number of users
$total_crs = getTotalCrs($conn);

//rooms
function getRecentVenues($conn) {
    $seven_days_ago = date('Y-m-d H:i:s', strtotime('-7 days'));
    $stmt = $conn->prepare("SELECT id, room_number, created_at FROM venues WHERE created_at >= ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $seven_days_ago);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $venues = [];
    while ($row = $result->fetch_assoc()) {
        $venues[] = $row;
    }

    $stmt->close();
    return $venues;
}

function getTotalBlocks($conn) {
  // Query to count the number of blocks
  $sql = "SELECT COUNT(*) AS total_blocks FROM blocks";
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result) {
      $row = $result->fetch_assoc();
      return $row['total_blocks'];
  } else {
      return 0;
  }
}

// Get the total number of blocks
$total_blocks = getTotalBlocks($conn);

// Function to get the total number of venues
function getTotalVenues($conn) {
  // Query to count the number of venues
  $sql = "SELECT COUNT(*) AS total_venues FROM venues";
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result) {
      $row = $result->fetch_assoc();
      return $row['total_venues'];
  } else {
      return 0;
  }
}

// Get the total number of venues
$total_venues = getTotalVenues($conn);

// Function to get the total number of blocks where status is inactive
function getTotalInactiveBlocks($conn) {
  // Query to count the number of blocks where status is inactive
  $sql = "SELECT COUNT(*) AS total_inactive_blocks FROM blocks WHERE status = 'inactive'";
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result) {
      $row = $result->fetch_assoc();
      return $row['total_inactive_blocks'];
  } else {
      return 0;
  }
}

// Get the total number of inactive blocks
$total_inactive_blocks = getTotalInactiveBlocks($conn);

function getTotalInactiveVenues($conn) {
  // Query to count the number of venues where status is inactive
  $sql = "SELECT COUNT(*) AS total_inactive_venues FROM venues WHERE status = 'inactive'";
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result) {
      $row = $result->fetch_assoc();
      return $row['total_inactive_venues'];
  } else {
      return 0;
  }
}


function countUsersByRoleAndDepartment($conn, $current_role, $department) {
    $count = 0; // Initialize the variable
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = ? AND department = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $current_role, $department);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
      
    } else {
        // Handle error, for example:
        error_log("Failed to prepare statement: " . $conn->error);
    }
    return $count;
}


// Get the total number of inactive venues
$total_inactive_venues = getTotalInactiveVenues($conn);
$active = $total_venues - $total_inactive_blocks;

$active_block = $total_blocks - $total_inactive_blocks;
// Close the database connection


//$conn->close();
?>
