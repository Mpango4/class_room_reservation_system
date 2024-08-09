<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<main id="main" class="main">
<div class="pagetitle">
  <h1>User Details</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item"><a href="users_list.php">Users</a></li>
      <li class="breadcrumb-item active">User Details</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">User Information</h5>
          <div class="row">
            <div class="col-md-6">
              <p><strong>First Name:</strong> <?php echo $user['firstname']; ?></p>
              <p><strong>Last Name:</strong> <?php echo $user['lastname']; ?></p>
              <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
              <p><strong>Phone Number:</strong> <?php echo $user['phonenumber']; ?></p>
              <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
              <p><strong>Department:</strong> <?php echo $user['department']; ?></p>
              <p><strong>Class:</strong> <?php echo $user['class']; ?></p>
            </div>
            <div class="col-md-6">
              <p><strong>Profile Picture:</strong></p>
              <img src="<?php echo "uploads/".$user['image']; ?>" alt="User Image" style="width:150px; height:150px;">
            </div>
            <div class="text-center">
             
              <?php if($current_role=='admin'){ ?>
              <a href="users_list.php" class="btn btn-secondary">Cancel</a>
              <?php } ?>
              <?php if($current_role=='hod'){ ?>
              <a href="CRS.php" class="btn btn-secondary">Cancel</a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php include("footer.php"); ?>
