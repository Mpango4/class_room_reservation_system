
<?php
session_start();
include("header.php");
include("sidebar.php");
include("db_connection.php"); // Include your database connection file

// Fetch department names from the database
$sql = "SELECT department_name FROM departments";
$result = $conn->query($sql);

$departments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row['department_name'];
    }
}
$conn->close();
?>

<div class="card">
<main id="main" class="main">
    <div class="card-body">
        <h5 class="card-title">Add new user</h5>

        <!-- Multi Columns Form -->
        <form class="row g-3" action="add_new_user.php" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="firstname" class="form-label">First name</label>
                <input type="text" class="form-control" id="firstname" name="firstname">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
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
            <div class="col-md-6">
                <label for="password5" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password5" name="password5">
            </div>
            <div class="col-8">
                <label for="phonenumber" class="form-label">Phone number</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="+255 555 5555 555">
            </div>
            <div class="col-md-4">
                <label for="role" class="form-label">Role</label>
                <select id="role" class="form-select" name="role">
                    <option selected>Choose...</option>
                    <?php if($current_role == 'admin') { ?>
                    <option value="admin">admin</option>
                    <option value="HOD">hod</option>
                    <?php } ?>
                    <option value="CR">CR</option>
                </select>
            </div>
            <div class="col-8">
                <label for="image" class="form-label">Choose an Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg, image/png">
            </div>
            <div class="col-4">
                <label for="classr" class="form-label">class (optional)</label>
                <input type="text" class="form-control" id="class" name="class" placeholder="DO21-IT">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </div>
</main>
</div>

<?php include("footer.php");?>
