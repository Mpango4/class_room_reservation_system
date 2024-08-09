<?php
session_start();

include("db_connection.php");
$sql = "SELECT department_name FROM departments";
$result = $conn->query($sql);

$departments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row['department_name'];
    }
}
// Check if user ID is set
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

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $class = $_POST['class'];

    $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, phonenumber = ?, role = ?, department = ?, class = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $phonenumber, $role, $department, $class, $user_id);

    if ($stmt->execute()) {
      header("location:CRS.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$current_role = $_SESSION['role']; // Assuming current role is stored in session
?>
<?php include("header.php");
include("sidebar.php"); ?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Edit User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item"><a href="users_list.php">Users</a></li>
      <li class="breadcrumb-item active">Edit User</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit User Information</h5>
          
          <!-- Edit User Form -->
          <form method="POST" action="">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
              </div>
              <div class="col-md-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
              </div>
              <div class="col-md-6">
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo htmlspecialchars($user['phonenumber']); ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required>
              </div>
              <?php //if($current_role == 'admin') { ?>
                <div class="col-md-6">
                <label for="department" class="form-label">Department</label>
                <select id="department" class="form-select" name="department">
                    <option selected>Choose...</option>
                    <?php if($current_role == 'admin') { ?>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
                    <?php endforeach; ?>
                    <?php } ?>
                    <?php if($current_role == 'hod') { ?>
                        <option value="<?=$department?>"><?=$department?></option>
                        <?php } ?>
                </select>
            </div>
              <?php //} ?>
              <?php if($current_role == 'hod' || $current_role == 'admin') { ?>
              <div class="col-md-6">
                <label for="class" class="form-label">Class</label>
                <input type="text" class="form-control" id="class" name="class" value="<?php echo htmlspecialchars($user['class']); ?>" required>
              </div>
              <?php } ?>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update</button>
             
              <?php if($current_role == 'hod') { ?>
              <a href="CRS.php" class="btn btn-secondary">Cancel</a>
              <?php } ?>
            </div>
          </form><!-- End Edit User Form -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php include("footer.php"); ?>
