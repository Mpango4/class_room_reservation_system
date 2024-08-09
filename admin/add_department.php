
<?php
session_start();
include("db_connection.php"); // include your database connection file

// Start or resume session


$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO departments (department_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $department_name, $description);

    if ($stmt->execute()) {
        $message = "New department added successfully.";
        // Store success message in session variable
        $_SESSION['success_message'] = $message;
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Check if success message is set in session
if (isset($_SESSION['success_message'])) {
    // Get success message from session
    $message = $_SESSION['success_message'];
    // Remove success message from session after displaying it
    unset($_SESSION['success_message']);
}
?>
<?php include("header.php");?>
<?php
include("sidebar.php");?>



<main id="main" class="main">
<div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New Department</h5>
                <div id="message" class="alert alert-success message <?php if($message) echo 'show'; ?>">
                    <?php echo $message; ?>
                </div>
                <form class="row g-3" action="add_department.php" method="POST">
                    <div class="col-md-12">
                        <label for="inputName5" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="inputName5" name="department_name" required>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description" style="height: 100px" required></textarea>
                        </div>           
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
